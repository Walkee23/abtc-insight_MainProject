<?php

namespace App\Support;

use RuntimeException;
use XMLReader;

/**
 * Minimal, dependency-free reader for .xlsx workbooks (and plain .csv files).
 *
 * An .xlsx file is a ZIP of XML parts. This class reads the ZIP's central directory itself and
 * inflates entries with gzinflate(), so it works on a stock XAMPP/PHP install without the zip
 * extension or Composer packages. Rows are streamed with XMLReader, so large sheets (tens of
 * thousands of rows) are read without loading the whole sheet into memory.
 *
 * Usage:
 *     $reader = new XlsxReader($path);              // or XlsxReader::open($path, 'xlsx'|'csv')
 *     foreach ($reader->rows() as $rowNumber => $cells) { ... }   // $cells: [0 => 'A', 1 => 'B', ...]
 */
class XlsxReader
{
    private string $path;
    private string $type;

    /** @var array<string, array{offset:int, csize:int, size:int, method:int}> */
    private array $entries = [];

    /** @var resource|null */
    private $zip = null;

    /** @var string[]|null */
    private ?array $shared = null;

    private ?array $dateStyles = null;

    /** @var array<int, array{name:string, path:string}>|null */
    private ?array $sheetList = null;

    /** @var string[] temp files holding inflated parts; removed in the destructor */
    private array $temps = [];

    public function __construct(string $path, ?string $type = null)
    {
        if (!is_file($path)) {
            throw new RuntimeException('The uploaded file could not be found.');
        }
        $this->path = $path;
        $this->type = $type ?: strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if ($this->type === 'xlsx') {
            $this->openZip();
        } elseif ($this->type !== 'csv') {
            throw new RuntimeException('Only .xlsx and .csv files can be imported.');
        }
    }

    public function __destruct()
    {
        if (is_resource($this->zip)) {
            fclose($this->zip);
        }
        foreach ($this->temps as $f) {
            @unlink($f);
        }
    }

    // ------------------------------------------------------------------ public API

    /**
     * Stream the rows of one worksheet (the first by default; see sheetNames()). Keys are 1-based row numbers; values are lists of
     * cell strings indexed from 0 (column A). Dates stored as Excel serial numbers are converted
     * to Y-m-d strings. Completely empty rows are skipped.
     *
     * @return \Generator<int, array<int, string>>
     */
    public function rows(int $sheetIndex = 0): \Generator
    {
        if ($this->type === 'csv') {
            yield from $this->csvRows();
            return;
        }

        $sheets = $this->sheetList();
        if (!isset($sheets[$sheetIndex])) {
            throw new RuntimeException('That sheet does not exist in the workbook.');
        }
        $shared = $this->sharedStrings();
        $dateStyles = $this->dateStyleIds();

        // the sheet can inflate to hundreds of MB: stream it through a temp file instead of holding it in memory
        $file = $this->extract($sheets[$sheetIndex]['path']);
        $xml = new XMLReader();
        $xml->open($file, null, LIBXML_NONET | LIBXML_COMPACT | LIBXML_PARSEHUGE);

        $rowNumber = 0;
        while ($xml->read()) {
            if ($xml->nodeType !== XMLReader::ELEMENT || $xml->name !== 'row') {
                continue;
            }
            $rowNumber = (int) ($xml->getAttribute('r') ?: $rowNumber + 1);
            $cells = [];
            $nextCol = 0;

            if (!$xml->isEmptyElement) {
                $depth = $xml->depth;
                while ($xml->read() && !($xml->nodeType === XMLReader::END_ELEMENT && $xml->depth === $depth)) {
                    if ($xml->nodeType !== XMLReader::ELEMENT || $xml->name !== 'c') {
                        continue;
                    }
                    $ref = $xml->getAttribute('r');
                    $col = $ref ? $this->columnIndex($ref) : $nextCol;
                    $nextCol = $col + 1;
                    $type = $xml->getAttribute('t');
                    $style = (int) $xml->getAttribute('s');

                    $value = '';
                    if (!$xml->isEmptyElement) {
                        $cellDepth = $xml->depth;
                        while ($xml->read() && !($xml->nodeType === XMLReader::END_ELEMENT && $xml->depth === $cellDepth)) {
                            if ($xml->nodeType !== XMLReader::ELEMENT) {
                                continue;
                            }
                            if ($xml->name === 'v') {
                                $value = $xml->readString();
                            } elseif ($xml->name === 't' && $type === 'inlineStr') {
                                $value .= $xml->readString();
                            }
                        }
                    }

                    if ($type === 's') {
                        $value = $shared[(int) $value] ?? '';
                    } elseif ($type === 'b') {
                        $value = $value === '1' ? 'TRUE' : 'FALSE';
                    } elseif (($type === null || $type === 'n' || $type === '') && $value !== '' && is_numeric($value) && isset($dateStyles[$style])) {
                        $value = $this->excelDate((float) $value) ?? $value;
                    }
                    $cells[$col] = trim((string) $value);
                }
            }

            if ($cells && array_filter($cells, fn($v) => $v !== '')) {
                $max = max(array_keys($cells));
                $filled = [];
                for ($i = 0; $i <= $max; $i++) {
                    $filled[$i] = $cells[$i] ?? '';
                }
                yield $rowNumber => $filled;
            }
        }
        $xml->close();
        // this sheet is done: free its temp file now instead of keeping every sheet on disk until the end
        @unlink($file);
        $this->temps = array_values(array_diff($this->temps, [$file]));
    }

    // ------------------------------------------------------------------ CSV

    private function csvRows(): \Generator
    {
        $fh = fopen($this->path, 'r');
        if (!$fh) {
            throw new RuntimeException('The file could not be opened.');
        }
        // skip a UTF-8 byte order mark
        if (fread($fh, 3) !== "\xEF\xBB\xBF") {
            rewind($fh);
        }
        $n = 0;
        while (($row = fgetcsv($fh, 0, ',', '"', '\\')) !== false) {
            $n++;
            $row = array_map(fn($v) => trim((string) $v), $row);
            if (array_filter($row, fn($v) => $v !== '')) {
                yield $n => $row;
            }
        }
        fclose($fh);
    }

    // ------------------------------------------------------------------ ZIP handling

    private function openZip(): void
    {
        $this->zip = fopen($this->path, 'rb');
        if (!$this->zip) {
            throw new RuntimeException('The file could not be opened.');
        }
        $size = filesize($this->path);
        if ($size < 22) {
            throw new RuntimeException('This does not look like an Excel (.xlsx) file.');
        }

        // locate the End Of Central Directory record (last 64 KB at most)
        $tail = min($size, 65557);
        fseek($this->zip, $size - $tail);
        $buf = fread($this->zip, $tail);
        $pos = strrpos($buf, "PK\x05\x06");
        if ($pos === false) {
            throw new RuntimeException('This does not look like an Excel (.xlsx) file.');
        }
        $eocd = unpack('vdisk/vcdisk/vrecs/vtotal/Vcdsize/Vcdoffset', substr($buf, $pos + 4, 18));

        fseek($this->zip, $eocd['cdoffset']);
        $cd = fread($this->zip, $eocd['cdsize']);
        $p = 0;
        for ($i = 0; $i < $eocd['total']; $i++) {
            if (substr($cd, $p, 4) !== "PK\x01\x02") {
                break;
            }
            $h = unpack('vmade/vneed/vflags/vmethod/vtime/vdate/Vcrc/Vcsize/Vsize/vnlen/vxlen/vclen/vdisk/viattr/Veattr/Voffset', substr($cd, $p + 4, 42));
            $name = substr($cd, $p + 46, $h['nlen']);
            $this->entries[$name] = ['offset' => $h['offset'], 'csize' => $h['csize'], 'size' => $h['size'], 'method' => $h['method']];
            $p += 46 + $h['nlen'] + $h['xlen'] + $h['clen'];
        }

        if (!isset($this->entries['[Content_Types].xml']) && !isset($this->entries['xl/workbook.xml'])) {
            throw new RuntimeException('This does not look like an Excel (.xlsx) file.');
        }
    }

    private function has(string $name): bool
    {
        return isset($this->entries[$name]);
    }

    private function read(string $name): string
    {
        $e = $this->entries[$name] ?? null;
        if (!$e) {
            throw new RuntimeException("The workbook is missing {$name}.");
        }
        fseek($this->zip, $e['offset']);
        $lh = fread($this->zip, 30);
        if (substr($lh, 0, 4) !== "PK\x03\x04") {
            throw new RuntimeException('The Excel file is damaged.');
        }
        $l = unpack('vnlen/vxlen', substr($lh, 26, 4));
        fseek($this->zip, $e['offset'] + 30 + $l['nlen'] + $l['xlen']);
        $data = $e['csize'] > 0 ? fread($this->zip, $e['csize']) : '';

        if ($e['method'] === 0) {
            return $data;
        }
        if ($e['method'] === 8) {
            $out = @gzinflate($data);
            if ($out === false) {
                throw new RuntimeException('The Excel file is damaged.');
            }
            return $out;
        }
        throw new RuntimeException('This Excel file uses an unsupported compression method.');
    }

    /** Inflates one part of the workbook into a temp file (in 1 MB steps) and returns the file's path. */
    private function extract(string $name): string
    {
        $e = $this->entries[$name] ?? null;
        if (!$e) {
            throw new RuntimeException("The workbook is missing {$name}.");
        }
        fseek($this->zip, $e['offset']);
        $lh = fread($this->zip, 30);
        if (substr($lh, 0, 4) !== "PK\x03\x04") {
            throw new RuntimeException('The Excel file is damaged.');
        }
        $l = unpack('vnlen/vxlen', substr($lh, 26, 4));
        fseek($this->zip, $e['offset'] + 30 + $l['nlen'] + $l['xlen']);

        $path = tempnam(sys_get_temp_dir(), 'xlsx');
        $this->temps[] = $path;
        $out = fopen($path, 'wb');

        $remaining = $e['csize'];
        if ($e['method'] === 0) {
            while ($remaining > 0) {
                $chunk = fread($this->zip, min($remaining, 1048576));
                fwrite($out, $chunk);
                $remaining -= strlen($chunk);
            }
        } elseif ($e['method'] === 8) {
            $ctx = inflate_init(ZLIB_ENCODING_RAW);
            while ($remaining > 0) {
                $chunk = fread($this->zip, min($remaining, 1048576));
                if ($chunk === '' || $chunk === false) {
                    break;
                }
                $remaining -= strlen($chunk);
                $data = @inflate_add($ctx, $chunk, $remaining > 0 ? ZLIB_NO_FLUSH : ZLIB_FINISH);
                if ($data === false) {
                    fclose($out);
                    throw new RuntimeException('The Excel file is damaged.');
                }
                fwrite($out, $data);
            }
        } else {
            fclose($out);
            throw new RuntimeException('This Excel file uses an unsupported compression method.');
        }
        fclose($out);
        return $path;
    }

    // ------------------------------------------------------------------ workbook parts

    /** @return array<int, array{name:string, path:string}> the worksheets in tab order (hidden ones included) */
    private function sheetList(): array
    {
        if ($this->sheetList !== null) {
            return $this->sheetList;
        }
        $list = [];
        // workbook.xml lists the sheets in order; workbook.xml.rels maps their ids to part names
        if ($this->has('xl/workbook.xml') && $this->has('xl/_rels/workbook.xml.rels')) {
            $wb = @simplexml_load_string($this->read('xl/workbook.xml'));
            $rels = @simplexml_load_string($this->read('xl/_rels/workbook.xml.rels'));
            if ($wb && $rels) {
                $targets = [];
                foreach ($rels->Relationship as $rel) {
                    $target = (string) $rel['Target'];
                    $targets[(string) $rel['Id']] = ltrim($target !== '' && $target[0] === '/' ? $target : 'xl/' . $target, '/');
                }
                $wb->registerXPathNamespace('m', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
                foreach ($wb->xpath('//m:sheets/m:sheet') ?: [] as $sheet) {
                    $rid = (string) $sheet->attributes('http://schemas.openxmlformats.org/officeDocument/2006/relationships')['id'];
                    $path = $targets[$rid] ?? '';
                    if ($path !== '' && $this->has($path)) {
                        $list[] = ['name' => (string) $sheet['name'], 'path' => $path];
                    }
                }
            }
        }
        if (!$list && $this->has('xl/worksheets/sheet1.xml')) {
            $list[] = ['name' => 'Sheet1', 'path' => 'xl/worksheets/sheet1.xml'];
        }
        if (!$list) {
            throw new RuntimeException('The workbook has no worksheet to read.');
        }
        return $this->sheetList = $list;
    }

    /** Names of the sheets (tabs) in the file, in order. A CSV file counts as one sheet. */
    public function sheetNames(): array
    {
        return $this->type === 'csv' ? ['CSV'] : array_column($this->sheetList(), 'name');
    }

    /** @return string[] */
    private function sharedStrings(): array
    {
        if ($this->shared !== null) {
            return $this->shared;
        }
        $this->shared = [];
        if (!$this->has('xl/sharedStrings.xml')) {
            return $this->shared;
        }
        $xml = new XMLReader();
        $xml->open($this->extract('xl/sharedStrings.xml'), null, LIBXML_NONET | LIBXML_PARSEHUGE);
        while ($xml->read()) {
            if ($xml->nodeType === XMLReader::ELEMENT && $xml->name === 'si') {
                // an <si> is either a plain <t> or several rich-text <r><t> runs; phonetic runs (<rPh>) are ignored
                $text = '';
                if (!$xml->isEmptyElement) {
                    $depth = $xml->depth;
                    while ($xml->read() && !($xml->nodeType === XMLReader::END_ELEMENT && $xml->depth === $depth)) {
                        if ($xml->nodeType === XMLReader::ELEMENT && $xml->name === 'rPh') {
                            $xml->next();
                            continue;
                        }
                        if ($xml->nodeType === XMLReader::ELEMENT && $xml->name === 't') {
                            $text .= $xml->readString();
                        }
                    }
                }
                $this->shared[] = $text;
            }
        }
        $xml->close();
        return $this->shared;
    }

    /** Style ids (cellXfs indexes) whose number format is a date/time. @return array<int,true> */
    private function dateStyleIds(): array
    {
        if ($this->dateStyles !== null) {
            return $this->dateStyles;
        }
        $this->dateStyles = [];
        if (!$this->has('xl/styles.xml')) {
            return $this->dateStyles;
        }
        $styles = @simplexml_load_string($this->read('xl/styles.xml'));
        if (!$styles) {
            return $this->dateStyles;
        }

        $custom = [];
        if (isset($styles->numFmts)) {
            foreach ($styles->numFmts->numFmt as $nf) {
                $custom[(int) $nf['numFmtId']] = (string) $nf['formatCode'];
            }
        }
        $builtinDates = [14, 15, 16, 17, 18, 19, 20, 21, 22, 45, 46, 47];

        $i = 0;
        if (isset($styles->cellXfs)) {
            foreach ($styles->cellXfs->xf as $xf) {
                $id = (int) $xf['numFmtId'];
                $isDate = in_array($id, $builtinDates, true);
                if (!$isDate && isset($custom[$id])) {
                    $code = preg_replace('/"[^"]*"|\[[^\]]*\]|\\\\./', '', $custom[$id]);
                    $isDate = (bool) preg_match('/[dmyhs]/i', $code);
                }
                if ($isDate) {
                    $this->dateStyles[$i] = true;
                }
                $i++;
            }
        }
        return $this->dateStyles;
    }

    // ------------------------------------------------------------------ helpers

    private function columnIndex(string $ref): int
    {
        $n = 0;
        for ($i = 0, $len = strlen($ref); $i < $len; $i++) {
            $ord = ord($ref[$i]);
            if ($ord >= 65 && $ord <= 90) {
                $n = $n * 26 + ($ord - 64);
            } elseif ($ord >= 97 && $ord <= 122) {
                $n = $n * 26 + ($ord - 96);
            } else {
                break;
            }
        }
        return max(0, $n - 1);
    }

    private function excelDate(float $serial): ?string
    {
        // a number that is not a plausible date (a typo in a date-formatted cell): keep the cell's own text
        if ($serial < 1 || $serial > 2958465) {
            return null;
        }
        // Excel counts days from 1899-12-30 (the 1900 leap-year bug is already absorbed by that epoch)
        $days = (int) floor($serial);
        $dt = (new \DateTimeImmutable('1899-12-30 00:00:00'))->modify("+{$days} days");
        return $dt->format('Y-m-d');
    }
}
