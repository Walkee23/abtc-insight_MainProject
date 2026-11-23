<?php

namespace App\Support;

/**
 * The PhilHealth status shown on the Staff Patient Lookup and the Health Worker Patient Database.
 *
 *   $claimed      what the patient said in the registration form (step 3): inflow_general_particulars.philhealth_member
 *   $verification what Staff found (Staff dashboard > PhilHealth Verification): NULL, 'Verified', 'Not a Member', 'Expired'
 *   $flag         the flag stored on the patient (patients.philhealth_member), used when there is no registration record
 */
class PhilhealthStatus
{
    /** @return array{0:string,1:string} [label, Tailwind classes for a badge] */
    public static function badge($claimed, ?string $verification, $flag): array
    {
        if ($verification === 'Verified') {
            return ['Verified member', 'bg-emerald-100 text-emerald-800'];
        }
        if ($verification === 'Expired') {
            return ['Expired', 'bg-amber-100 text-amber-800'];
        }
        if ($verification === 'Not a Member') {
            return ['Not a member', 'bg-slate-100 text-slate-600'];
        }
        if ($claimed) {
            return ['Pending verification', 'bg-sky-100 text-sky-800'];   // said "member", not checked yet
        }

        return $flag ? ['Member', 'bg-emerald-100 text-emerald-800'] : ['Non-member', 'bg-slate-100 text-slate-600'];
    }
}
