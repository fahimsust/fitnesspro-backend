<?php

namespace Tests\RequestFactories\App\Api\Admin\Accounts\Requests;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Worksome\RequestFactories\RequestFactory;

class AccountMembershipRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $startDate = Carbon::createFromTimestamp($this->faker->dateTimeBetween('-1 years', '+0 years')->getTimestamp());
        $startDateFormatted = $startDate->format('Y-m-d H:i:s');
        $endDate = clone $startDate;
        $endDate->addMonths(rand(1, 8));
        $endDateFormatted = $endDate->format('Y-m-d H:i:s');

        return [
            'amount_paid' => 100,
            'start_date' => $startDateFormatted,
            'end_date' => $endDateFormatted,
            'level_id'=>MembershipLevel::firstOrFactory()->id,
            'account_id'=>Account::firstOrFactory()->id
        ];
    }
}
