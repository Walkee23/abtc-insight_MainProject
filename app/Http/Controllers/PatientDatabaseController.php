<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientDatabaseController extends Controller
{
    /**
     * Only cases Staff has finished (Case Encoding "Complete Encoding" sets the walk-in
     * record to 'Encoded') belong to the Health Worker. A bite_cases row can already
     * exist from a Staff draft, so its existence alone is not the hand-off.
     */
    private function handedOff($query, string $alias = 'bc')
    {
        return $query->whereExists(function ($e) use ($alias) {
            $e->select(DB::raw(1))->from('inflow_general_particulars as hg')
                ->whereColumn('hg.inflow_record_id', $alias . '.inflow_record_id')
                ->where('hg.status', 'Encoded');
        });
    }

    /**
     * Health Worker Patient Database: every verified patient (a `patients` row only
     * exists after Staff verification), with their latest case and PEP status.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $status = in_array($request->query('status'), ['active', 'completed'], true) ? $request->query('status') : 'all';

        // A case is "unfinished" until Clinical Encoding is finalized (outcome = 'Completed')
        $unfinishedCase = function ($q) {
            $this->handedOff($q->select(DB::raw(1))->from('bite_cases as uc'), 'uc')
                ->whereColumn('uc.patient_id', 'p.patient_id')
                ->where(function ($w) {
                    $w->whereNull('uc.outcome')->orWhere('uc.outcome', '<>', 'Completed');
                });
        };

        $query = DB::table('patients as p')
            ->select('p.patient_id', 'p.patient_name', 'p.age', 'p.sex')
            ->selectSub(
                $this->handedOff(DB::table('bite_cases as lc'), 'lc')->select('lc.barangay')
                    ->whereColumn('lc.patient_id', 'p.patient_id')
                    ->orderByDesc('lc.date_verified')->limit(1),
                'barangay'
            )
            ->selectSub(
                $this->handedOff(DB::table('bite_cases as vc'), 'vc')->select(DB::raw('MAX(vc.date_verified)'))
                    ->whereColumn('vc.patient_id', 'p.patient_id'),
                'last_visit'
            );

        foreach (preg_split('/\s+/', $search, -1, PREG_SPLIT_NO_EMPTY) as $term) {
            $like = '%' . addcslashes($term, '%_\\') . '%';
            $query->where(function ($q) use ($like) {
                $q->where('p.patient_name', 'like', $like)
                    ->orWhere('p.patient_id', 'like', $like)
                    ->orWhereExists(function ($e) use ($like) {
                        $this->handedOff($e->select(DB::raw(1))->from('bite_cases as sc'), 'sc')
                            ->whereColumn('sc.patient_id', 'p.patient_id')
                            ->where('sc.barangay', 'like', $like);
                    });
            });
        }

        if ($status === 'active') {
            $query->whereExists($unfinishedCase);
        } elseif ($status === 'completed') {
            $query->whereNotExists($unfinishedCase)
                ->whereExists(function ($q) {
                    $this->handedOff($q->select(DB::raw(1))->from('bite_cases as cc'), 'cc')
                        ->whereColumn('cc.patient_id', 'p.patient_id');
                });
        }

        $patients = $query->orderByRaw('last_visit IS NULL')->orderByDesc('last_visit')
            ->orderBy('p.patient_name')
            ->paginate(10)
            ->withQueryString();

        // Case history for the patients on this page (drives the status badge and the record modal)
        $ids = $patients->pluck('patient_id')->all();
        $cases = $this->handedOff(DB::table('bite_cases as bc'))
            ->leftJoin('bite_section6_wound_description as s6', 's6.bite_case_id', '=', 'bc.bite_case_id')
            ->leftJoin('bite_section7_immunization as s7', 's7.bite_case_id', '=', 'bc.bite_case_id')
            ->leftJoin('bite_section9_progress_notes as s9', 's9.bite_case_id', '=', 'bc.bite_case_id')
            ->whereIn('bc.patient_id', $ids)
            ->orderByDesc('bc.date_verified')
            ->get([
                'bc.bite_case_id', 'bc.patient_id', 'bc.case_number', 'bc.category', 'bc.barangay',
                'bc.date_verified', 'bc.outcome',
                's6.wound_desc_id', 's9.progress_id', 's7.day0_date',
            ])
            ->groupBy('patient_id');

        $details = DB::table('patients')->whereIn('patient_id', $ids)->get()->keyBy('patient_id');

        $records = [];
        foreach ($patients as $patient) {
            $patientCases = ($cases[$patient->patient_id] ?? collect())->map(function ($c) {
                $finished = $c->outcome === 'Completed';
                return [
                    'bite_case_id' => $c->bite_case_id,
                    'case_number' => $c->case_number,
                    'category' => $c->category,
                    'barangay' => $c->barangay,
                    'date' => \Carbon\Carbon::parse($c->date_verified)->format('M d, Y'),
                    'status' => $finished ? 'Completed'
                        : (($c->progress_id || $c->wound_desc_id || $c->day0_date) ? 'In Progress' : 'Awaiting Encoding'),
                    'finished' => $finished,
                ];
            })->values();

            // Patient-level status: any unfinished case wins
            $open = $patientCases->firstWhere('finished', false);
            $patient->pep_status = $patientCases->isEmpty() ? 'No Case' : ($open ? $open['status'] : 'Completed');

            $d = $details[$patient->patient_id];
            $records[$patient->patient_id] = [
                'name' => $patient->patient_name,
                'age' => $d->age,
                'sex' => $d->sex,
                'dob' => $d->date_of_birth ? \Carbon\Carbon::parse($d->date_of_birth)->format('M d, Y') : null,
                'civil_status' => $d->civil_status,
                'contact' => $d->contact_num,
                'philhealth' => $d->philhealth_member ? ($d->philhealth_name ?: 'Member') : 'Not a member',
                'illness' => $d->illness_history,
                'allergy' => $d->allergy_history,
                'cases' => $patientCases,
            ];
        }

        return view('healthworker.Patient_Lookup&DB', compact('patients', 'records', 'search', 'status'));
    }
}
