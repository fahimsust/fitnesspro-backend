<?php

namespace Domain\Accounts\Jobs;

use Domain\Accounts\Actions\Registration\Mail\SendVerificationEmail;
use Domain\Accounts\Models\Account;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendVerificationEmailOnCreation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Account $account
    )
    {
    }

    public function handle()
    {
        SendVerificationEmail::run($this->account);
    }
}
