<?php

namespace Domain\Reports\Actions;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountType;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\Models\Specialty;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Domain\Products\Enums\ProductOptionTypes;
use Domain\Reports\Models\Report;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Support\Facades\DB;

class BuildCustomerReport
{
    use AsObject;
    public array $header = [];

    public function handle($criteria,Report $report)
    {
        $this->header[] = "Report - ".$report->name;
        if (isset($criteria->start_date) && $criteria->start_date && isset($criteria->end_date) && $criteria->end_date) {
            $this->header[] = Carbon::parse($criteria->start_date)->format('Y-m-d g:i A')." thru ".Carbon::parse($criteria->end_date)->format('Y-m-d g:i A');
        }
        else if (isset($criteria->start_date) && $criteria->start_date) {
            $this->header[] = "From Date : ".Carbon::parse($criteria->start_date)->format('Y-m-d g:i A');
        }
        else if (isset($criteria->end_date) && $criteria->end_date) {
            $this->header[] = "To Date : ".Carbon::parse($criteria->end_date)->format('Y-m-d g:i A');
        }
        else
        {
            $this->header[] ="Date: No Date Range Selected";
        }
        $report->update(['ready'=>1]);
        $query = $this->buildQuery($criteria);
        $customers = $query->lazy();
        return [$customers,$this->header];
    }

    private function buildQuery($criteria)
    {
        $query = Account::select([
            'id',
            'first_name',
            'last_name',
            'username',
            'email',
            'created_at',
            'lastlogin_at',
            'status_id',
            'type_id'
        ])
        ->with([
            'activeMembership:account_id,start_date,end_date,cancelled,level_id,subscription_price',
            'memberships:account_id,start_date,end_date,cancelled,level_id,subscription_price',
            'memberships.level:name',
            'defaultShippingAddress:account_id,city,state_id,country_id',
            'defaultShippingAddress.stateProvince:name',
            'defaultShippingAddress.country:name',
            'status:name',
            'type:name'
        ]);

        $this->applyMembershipFilters($criteria, $query);
        $this->applyAccountStatusFilters($criteria, $query);
        $this->applyAccountTypeFilter($criteria, $query);
        $this->applySpecialtyFilter($criteria, $query);
        $this->applyOrderFilter($criteria, $query);
        $this->applyShippingAddressFilter($criteria, $query);
        $this->applyTravelOrderFilter($criteria,$query);

        return $query;
    }

    private function applyMembershipFilters($criteria, $query)
    {
        if (isset($criteria->membership_level) && $criteria->membership_level > 0) {
            $query->whereHas('memberships', function ($subQuery) use ($criteria) {
                $subQuery->where('level_id', $criteria->membership_level);
            });
            $level = MembershipLevel::find($criteria->membership_level);
            $this->header[] = "Membership Level: " . $level->name;
        }
    }

    private function applyAccountStatusFilters($criteria, $query)
    {
        if (isset($criteria->account_status)) {
            if ($criteria->account_status == 2) {
                $query->whereHas('activeMembership', function ($subQuery) use ($criteria) {
                    $this->startEndDateConitionBetween($criteria,$subQuery, DB::raw('IF(cancelled IS NULL OR cancelled > end_date, end_date, cancelled)'));
                });
                $this->header[] = "Active Membership (within date range)";
            } elseif ($criteria->account_status > 0) {
                if ($criteria->account_status == 1) {
                     $query = $this->startEndDateConition($criteria, $query, "lastlogin_at");
                    $this->header[] = "Last Login (within date range)";
                } elseif ($criteria->account_status == 3) {
                    $query->whereHas('memberships', function ($subQuery) use ($criteria) {
                        $this->startEndDateConition($criteria, $subQuery, "created");
                    });
                    $this->header[] = "Created/Renewed Membership (within date range)";
                } elseif ($criteria->account_status == 4) {
                    $query->whereHas('memberships', function ($subQuery) use ($criteria) {
                        $this->startEndDateConition($criteria, $subQuery, DB::raw('IF(cancelled IS NULL OR cancelled > end_date, end_date, cancelled)'));
                    });
                    $this->header[] = "Membership Expired/Expiring (within date range)";
                }
                elseif ($criteria->account_status == 5) {
                    $query->whereHas('inactiveMemberships', function ($subQuery) use ($criteria) {
                        $this->startEndDateConitionBetween($criteria,$subQuery, DB::raw('IF(cancelled IS NULL OR cancelled > end_date, end_date, cancelled)'));
                    });
                    $this->header[] = "InActive Membership (within date range)";
                }
            }
        }
    }

    private function applyAccountTypeFilter($criteria, $query)
    {
        if (isset($criteria->account_type_id) && $criteria->account_type_id) {
            $query->whereIn('type_id', $criteria->account_type_id);
            $accountTypes = AccountType::whereIn('id',$criteria->account_type_id)->get()->pluck('name')->implode(", ");
            $this->header[] = "Account Type: " . $accountTypes;
        }
    }

    private function applySpecialtyFilter($criteria, $query)
    {
        if (isset($criteria->specialties) && $criteria->specialties) {
            if (isset($criteria->specialty_allany) && $criteria->specialty_allany == 0) {
                $query->whereHas('specialties', function ($subQuery) use ($criteria) {
                    $subQuery->whereIn('specialty_id', $criteria->specialties);
                });
                $match = "Any";
            } else {
                $query->whereHas('specialties', function ($subQuery) use ($criteria) {
                    $subQuery->whereIn('specialty_id', $criteria->specialties);
                }, '=', count($criteria->specialties));
                $match = "All";
            }
            $accountSpeciality = Specialty::whereIn("id", $criteria->specialties)->get()->pluck('name')->implode(", ");
            $this->header[] = "Specialty (" . $match . "): " .  $accountSpeciality;
        }
    }

    private function applyOrderFilter($criteria, $query)
    {
        if (isset($criteria->has_ordered) && $criteria->has_ordered > 0) {
            if ($criteria->has_ordered == 1) {
                $query->whereHas('orders', function ($subQuery) use ($criteria) {
                    $this->startEndDateConition($criteria, $subQuery, "created_at");
                });
                $this->header[] = "Has Ordered";
            } else {
                $query->whereDoesntHave('orders');
                $this->header[] = "Has NOT Ordered";
            }
        }
    }

    private function applyTravelOrderFilter($criteria, $query)
    {
        if (isset($criteria->has_travel_ordered) && $criteria->has_travel_ordered > 0) {
            if ($criteria->has_travel_ordered == 1) {
                $query->whereHas('rangeOption', function ($subQuery) use ($criteria) {
                    $subQuery->where('type_id',ProductOptionTypes::DateRange)->whereHas('optionValues', function ($subQuery2) use ($criteria) {
                        $this->startEndDateConitionBetween($criteria, $subQuery2, "end_date");
                    });
                });
                $this->header[] = "Has Travel Product Ordered";
            } else {
                $query->whereDoesntHave('rangeOption');
                $this->header[] = "Has NOT Ordered Travel Product";
            }
        }
    }

    private function applyShippingAddressFilter($criteria, $query)
    {
        if ((isset($criteria->ship_to_country) && $criteria->ship_to_country) || (isset($criteria->ship_to_city) && $criteria->ship_to_city) || (isset($criteria->ship_to_state) && $criteria->ship_to_state)) {
            $query->whereHas('defaultShippingAddress', function ($subQuery) use ($criteria) {
                if (isset ($criteria->ship_to_country) && $criteria->ship_to_country) {
                    $country = Country::find($criteria->ship_to_country);
                    $subQuery->where('country_id', $criteria->ship_to_country);
                    $this->header[] = "Country: " . $country->name;
                }
                if (isset ($criteria->ship_to_city) && $criteria->ship_to_city) {
                    $subQuery->where('city', 'like', '%' . $criteria->ship_to_city . '%');
                    $this->header[] = "Ship to City: " . $criteria->ship_to_city;
                }
                if (isset ($criteria->ship_to_state) && $criteria->ship_to_state) {
                    $states = StateProvince::whereIn("id", $criteria->ship_to_state)->get()->pluck('name')->toArray();
                    $subQuery->whereIn('state_id', $criteria->ship_to_state);
                    $this->header[] = "States: " . implode(",", $states);
                }
            });
        }
    }

    function startEndDateConition($criteria, $query, $field)
    {
        if (isset($criteria->start_date) && $criteria->start_date) {
            $query->where($field, '>=', $criteria->start_date);
        }
        if (isset($criteria->end_date) && $criteria->end_date) {
            $query->where($field, '<=', $criteria->end_date);
        }
        return $query;
    }

    function startEndDateConitionBetween($criteria, $query, $cancelledExpression)
    {
        if (isset($criteria->start_date) && isset($criteria->end_date) && $criteria->start_date && $criteria->end_date) {
            $query->where(function ($subQueryMain) use ($criteria, $cancelledExpression) {
                $subQueryMain->where(function ($subQuery) use ($criteria, $cancelledExpression) {
                    $subQuery->whereBetween('start_date', [$criteria->start_date,$criteria->end_date]);
                    $subQuery->orWhereBetween($cancelledExpression, [$criteria->start_date,$criteria->end_date]);
                });
                $subQueryMain->orWhere(function ($subQuery) use ($criteria, $cancelledExpression) {
                    $subQuery->where('start_date', '<=', $criteria->start_date);
                    $subQuery->where($cancelledExpression, '>=', $criteria->end_date);
                });
            });
        }else if (isset($criteria->start_date) && $criteria->start_date) {
            $query->where('start_date','<=',$criteria->start_date);
            $query->where('end_date','>=',$criteria->start_date);
        } else if (isset($criteria->end_date) && $criteria->end_date) {
            $query->where('start_date','<=',$criteria->end_date);
            $query->where('end_date','>=',$criteria->end_date);
        }
        return $query;
    }
}
