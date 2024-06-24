<?php

namespace App\Console;

use Domain\Accounts\Jobs\Membership\CheckUpcomingAutoRenewMemberships;
use Domain\Accounts\Jobs\Membership\ManageAutoRenewMembershipsExpiringTomorrow;
use Domain\Accounts\Jobs\Membership\SendRemindersToTrialMemberships;
use Domain\Accounts\Jobs\Membership\UpdateMembershipStatusForExpiredMemberships;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();


        //check for memberships that expired yesterday (or earlier that have not been set to status 0)
        //and update membership_status for account
        $schedule
            ->job(new UpdateMembershipStatusForExpiredMemberships)
            ->dailyAt('2:00');

        //check for trial memberships that will
        ////expire in 14 days
        ////expire in 5 days
        $schedule
            ->job(new SendRemindersToTrialMemberships)
            ->dailyAt('2:15');

        //check for auto renew memberships that will renew in 30 days
        ////and check renew payment data will still be valid in 30 days
        $schedule->job(new CheckUpcomingAutoRenewMemberships)
            ->dailyAt('2:30');

        //check for auto renew accounts expiring tomorrow to auto-renew them
        $schedule->job(new ManageAutoRenewMembershipsExpiringTomorrow)
            ->dailyAt('4:30');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
