<?php

namespace Domain\Accounts\Jobs\Membership;


use Domain\Accounts\Actions\Membership\ValidateAccountReadyForAutoRenewal;
use Domain\Accounts\Models\Account;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckUpcomingAutoRenewMemberships implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $thirtyDaysFromNow = now()->addDays(30)->format("Y-m-d");

        Account::query()
            ->withWhereHas('activeMembership',
                fn($query) => $query
                    ->whereAutoRenew(true)
                    ->where(
                        'end_date',
                        '>=',
                        $thirtyDaysFromNow . " 00:00:00"
                    )
                    ->where(
                        'end_date',
                        '<=',
                        $thirtyDaysFromNow . " 23:59:59"
                    )
            )
            ->whereMembershipStatus(true)
            ->lazyById(100)
            ->each(
                fn(Account $account) => $this->checkAccount($account)
            );
    }

    private function checkAccount(Account $account)
    {
        ValidateAccountReadyForAutoRenewal::run($account, true);
    }
}
