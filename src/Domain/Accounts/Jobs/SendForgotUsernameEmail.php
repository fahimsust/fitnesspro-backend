<?php

namespace Domain\Accounts\Jobs;

use Domain\Accounts\Mail\AccountForgotUsername;
use Domain\Accounts\Models\Account;
use Domain\Sites\Models\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendForgotUsernameEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Account $account,
    ) {
    }

    public function handle()
    {
        Site::SendMailable(new AccountForgotUsername($this->account));
    }
}
