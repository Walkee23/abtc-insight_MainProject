/*
 * Patient ID QR code: scan it with the camera or upload a photo of it (Returning Patient, Tracking Portal).
 *
 * Only a real Patient ID QR code is accepted (CEB-YYYYMMDD-YYYYMMDD-NNN). Uploads are limited to genuine PNG or JPEG
 * images: the file name, the type the browser reports, the size AND the first bytes of the file are checked, so a
 * renamed PDF, SQL script or any other file is turned away. The image is decoded in the browser and never uploaded.
 *
 * Needs the html5-qrcode library and the markup of partials/patient-qr-modal.blade.php on the page.
 *
 *   PatientQr.init({ openButton: 'scanQrBtn', onCode: function (patientId) { ... } });
 */
(function () {
    'use strict';

    var PATIENT_ID_RE = /^CEB-\d{8}-\d{8}-\d{1,6}$/;
    var MAX_BYTES = 5 * 1024 * 1024;
    var TAB_ON = 'py-2 px-3 rounded-lg text-xs font-bold bg-white text-primary shadow-sm transition-all flex items-center justify-center gap-1.5';
    var TAB_OFF = 'py-2 px-3 rounded-lg text-xs font-bold text-on-surface-variant hover:text-on-surface transition-all flex items-center justify-center gap-1.5';

    function $(id) { return document.getElementById(id); }

    // The real file type is read from the first bytes of the file, not from its name or the type the browser reports
    function isRealPngOrJpeg(file) {
        return file.slice(0, 12).arrayBuffer().then(function (buf) {
            var b = new Uint8Array(buf);
            var png = b.length >= 8 && [0x89, 0x50, 0x4E, 0x47, 0x0D, 0x0A, 0x1A, 0x0A].every(function (v, i) { return b[i] === v; });
            var jpeg = b.length >= 3 && b[0] === 0xFF && b[1] === 0xD8 && b[2] === 0xFF;
            return png || jpeg;
        });
    }

    function init(options) {
        var modal = $('qrScannerModal');
        var openButton = $(options.openButton);
        if (!modal || !openButton || typeof Html5Qrcode === 'undefined') return;

        var errorBox = $('qrModalError');
        var fileInput = $('qrFileInput');
        var camera = null;
        var lastBadScan = '';
        var fileScanner = new Html5Qrcode('qrFileReader');

        function showError(msg) { errorBox.textContent = msg; errorBox.classList.remove('hidden'); }
        function clearError() { errorBox.textContent = ''; errorBox.classList.add('hidden'); }

        function useCode(rawText) {
            var id = String(rawText || '').trim().toUpperCase();
            if (!PATIENT_ID_RE.test(id)) {
                if (id !== lastBadScan) {   // the camera sees the same wrong code many times a second: say it once
                    lastBadScan = id;
                    showError('Invalid QR code. Only the Patient ID QR code from your visit (CEB-XXXXXXXX-XXXXXXXX-XXX) is accepted.');
                }
                return false;
            }
            clearError();
            closeModal();
            options.onCode(id);
            return true;
        }

        function stopCamera() {
            if (camera && camera.isScanning) return camera.stop().catch(function () {});
            return Promise.resolve();
        }
        function startCamera() {
            clearError(); lastBadScan = '';
            if (!camera) camera = new Html5Qrcode('qrReader');
            if (camera.isScanning) return;
            camera.start({ facingMode: 'environment' }, { fps: 10, qrbox: { width: 240, height: 240 } },
                function (text) { useCode(text); }, function () {})
                .catch(function () { showError('Camera unavailable or permission denied. Switch to "Upload QR Photo" above.'); });
        }

        function tab(cameraTab) {
            clearError(); lastBadScan = '';
            $('tabCameraBtn').className = cameraTab ? TAB_ON : TAB_OFF;
            $('tabUploadBtn').className = cameraTab ? TAB_OFF : TAB_ON;
            $('cameraPanel').classList.toggle('hidden', !cameraTab);
            $('uploadPanel').classList.toggle('hidden', cameraTab);
            if (cameraTab) startCamera(); else stopCamera();
        }
        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            tab(true);
        }
        function closeModal() {
            stopCamera();
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            fileInput.value = '';
            clearError();
        }

        openButton.addEventListener('click', openModal);
        $('closeQrModalBtn').addEventListener('click', closeModal);
        $('tabCameraBtn').addEventListener('click', function () { tab(true); });
        $('tabUploadBtn').addEventListener('click', function () { tab(false); });
        modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal(); });

        function pickFile() { fileInput.value = ''; fileInput.click(); }
        $('qrFileDropzone').addEventListener('click', pickFile);
        $('qrFileDropzone').addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); pickFile(); } });

        fileInput.addEventListener('change', function (e) {
            var file = e.target.files[0];
            if (!file) return;
            clearError(); lastBadScan = '';
            function reject(msg) { showError(msg); fileInput.value = ''; }

            // 1. name, reported type and size
            if (!/\.(png|jpe?g)$/i.test(file.name) || ['image/png', 'image/jpeg'].indexOf(file.type) === -1) {
                return reject('Invalid file. Only a PNG or JPG image of your QR code can be uploaded.');
            }
            if (file.size === 0) return reject('This image is empty. Please choose your QR code photo.');
            if (file.size > MAX_BYTES) return reject('The image must be smaller than 5 MB.');

            // 2. what the file really is (a renamed PDF, script or other file is turned away here)
            isRealPngOrJpeg(file).then(function (real) {
                if (!real) return reject('Invalid file. This is not a real PNG or JPG image.');
                // 3. it must contain a Patient ID QR code
                return fileScanner.scanFile(file, false)
                    .then(function (text) { useCode(text); })
                    .catch(function () { showError('No QR code detected in this image. Please upload a clear photo of your Patient ID QR code.'); })
                    .then(function () { fileInput.value = ''; });
            });
        });
    }

    window.PatientQr = { init: init, PATIENT_ID_RE: PATIENT_ID_RE };
})();
