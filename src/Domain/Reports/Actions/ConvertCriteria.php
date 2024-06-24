<?php

namespace Domain\Reports\Actions;

use Domain\Accounts\Models\AccountType;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\Models\Specialty;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Domain\Reports\Models\Report;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsObject;

class ConvertCriteria
{
    use AsObject;

    public function handle(
        $criteria
    ) {
        $criteria = json_decode($criteria);
        // Convert specialties IDs to names
        if ($criteria->specialties && is_array($criteria->specialties) && count($criteria->specialties) > 0) {
            $specialtyNames = Specialty::whereIn('id', $criteria->specialties)->pluck('name')->toArray();
            $criteria->specialties = $specialtyNames;
        }

        // Convert ship_to_state IDs to names
        if ($criteria->ship_to_state && is_array($criteria->ship_to_state) && count($criteria->ship_to_state) > 0) {
            $stateNames = StateProvince::whereIn('id', $criteria->ship_to_state)->pluck('name')->toArray();
            $criteria->ship_to_state = $stateNames;
        }

        // Convert account_type_id IDs to names
        if ($criteria->account_type_id && is_array($criteria->account_type_id) && count($criteria->account_type_id) > 0) {
            $accountTypeNames = AccountType::whereIn('id', $criteria->account_type_id)->pluck('name')->toArray();
            $criteria->account_type_id = $accountTypeNames;
        }

        // Convert ship_to_country ID to name
        if ($criteria->ship_to_country) {
            $countryName = Country::find($criteria->ship_to_country)->name ?? null;
            $criteria->ship_to_country = $countryName;
        }

        // Convert membership_level ID to name
        if ($criteria->membership_level) {
            $membershipLevelName = MembershipLevel::find($criteria->membership_level)->name ?? null;
            $criteria->membership_level = $membershipLevelName;
        }
        return $criteria;
    }
}
