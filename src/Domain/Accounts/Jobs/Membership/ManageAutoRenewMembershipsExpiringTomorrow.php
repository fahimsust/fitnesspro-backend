<?php

namespace Domain\Accounts\Jobs\Membership;


use Domain\Accounts\Models\Account;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ManageAutoRenewMembershipsExpiringTomorrow implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tomorrow = now()->addDays(1)->format("Y-m-d");

        Account::query()
            ->withWhereHas('activeMembership',
                fn($query) => $query
                    ->whereAutoRenew(true)
                    ->where(
                        'end_date',
                        '>=',
                        $tomorrow . " 00:00:00"
                    )
                    ->where(
                        'end_date',
                        '<=',
                        $tomorrow . " 23:59:59"
                    )
            )
            ->whereMembershipStatus(true)
            ->lazyById(100)
            ->each(
                fn(Account $account) => AutoRenewMembership::dispatch($account)
            );
    }
}
