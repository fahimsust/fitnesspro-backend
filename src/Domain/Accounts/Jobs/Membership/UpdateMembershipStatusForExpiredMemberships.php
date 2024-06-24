<?php

namespace Domain\Accounts\Jobs\Membership;


use Domain\Accounts\Models\Account;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateMembershipStatusForExpiredMemberships implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Account::query()
            ->whereDoesntHave('activeMembership')
            ->whereMembershipStatus(true)
            ->lazyById(100)
            ->each(
                fn(Account $account) => $this->accountMembershipExpired($account)
            );
    }

    private function accountMembershipExpired(Account $account)
    {
        $account->memberships()
            ->whereStatus(1)
            ->update([
                'status' => 0
            ]);

        $account->update([
            'membership_status' => false
        ]);
    }
}
