<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GisMapController extends Controller
{
    public function index()
    {
        return view('admin.gis_map', ['healthAreas' => config('health_areas.areas')]);
    }

    /** Filtered case counts: one row per barangay + category + animal. The map page does the rest. */
    public function data(Request $r)
    {
        $r->validate([
            'from'     => 'nullable|date',
            'to'       => 'nullable|date',
            'category' => 'nullable|in:I,II,III',
            'animal'   => 'nullable|in:dog,cat,others',
            'ownership'   => 'nullable|in:pet,stray',
            'health_area' => 'nullable|in:central,east,north,south,west',
        ]);

        $q = DB::table('bite_cases as bc')
            ->leftJoin('bite_section3_exposure as e', 'e.bite_case_id', '=', 'bc.bite_case_id')
            ->selectRaw("bc.barangay, bc.category,
             COALESCE(e.animal_type, 'Unrecorded') as animal,
             COALESCE(e.animal_ownership, 'Unrecorded') as ownership,
             COUNT(DISTINCT bc.bite_case_id) as n")
            ->groupBy('bc.barangay', 'bc.category', 'animal', 'ownership');

        // Date = bite date if encoded, otherwise the date the case was verified
        $date = 'DATE(COALESCE(e.bite_date_time, bc.date_verified))';
        if ($r->filled('from')) $q->whereRaw("$date >= ?", [$r->from]);
        if ($r->filled('to'))   $q->whereRaw("$date <= ?", [$r->to]);

        if ($r->filled('category')) $q->where('bc.category', $r->category);

        // Animal: Dogs / Cats / Others (anything recorded that is not a dog or cat)
        if ($r->animal === 'dog')    $q->where('e.animal_type', 'like', 'Dog%');
        if ($r->animal === 'cat')    $q->where('e.animal_type', 'like', 'Cat%');
        if ($r->animal === 'others') $q->whereNotNull('e.animal_type')
                                        ->where('e.animal_type', 'not like', 'Dog%')
                                        ->where('e.animal_type', 'not like', 'Cat%');

        if ($r->ownership === 'pet')   $q->where('e.animal_ownership', 'like', 'Pet%');
        if ($r->ownership === 'stray') $q->where('e.animal_ownership', 'like', 'Stray%');

        if ($r->filled('health_area')) {
            $area = config('barangays.areas.' . strtoupper($r->health_area) . ' HEALTH AREA');
            $q->whereIn('bc.barangay', $area['barangays'] ?? []);
        }

        return response()->json($q->get());
    }
}