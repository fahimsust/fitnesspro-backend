<?php

namespace Domain\Accounts\Jobs\Membership;


use Domain\Accounts\Mail\TrialMembershipExpirationReminder1;
use Domain\Accounts\Mail\TrialMembershipExpirationReminder2;
use Domain\Accounts\Models\Account;
use Domain\Sites\Models\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendRemindersToTrialMemberships implements ShouldQueue
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
            ->withWhereHas('activeMembership',
                fn($query) => $query
                    ->whereHas(
                        'level',
                        fn($query) => $query->where('trial', true)
                    )
                    ->where(function ($query) {
                        $query
                            ->orWhere(function ($query) {
                                $query
                                    ->where(
                                        'end_date',
                                        '<=',
                                        now()->addDays(14)
                                    )
                                    ->where(
                                        'end_date',
                                        '>',
                                        now()->addDays(5)
                                    )
                                    ->where('expirealert1_sent', false);
                            })
                            ->orWhere(function ($query) {
                                $query
                                    ->where(
                                        'end_date',
                                        '<=',
                                        now()->addDays(5)
                                    )
                                    ->where('expirealert2_sent', false);
                            });
                    })
            )
            ->whereMembershipStatus(true)
            ->lazyById(100)
            ->each(
                fn(Account $account) => $this->remindAccount($account)
            );
    }

    private function remindAccount(Account $account)
    {
        if ($account->activeMembership->end_date <= now()->addDays(5)) {
            $account->activeMembership->update(['expirealert2_sent' => true]);

            Site::SendMailable(
                new TrialMembershipExpirationReminder2($account)
            );

            return;
        }

        $account->activeMembership->update(['expirealert1_sent' => true]);

        Site::SendMailable(
            new TrialMembershipExpirationReminder1($account)
        );
    }
}
