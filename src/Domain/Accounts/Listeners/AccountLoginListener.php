<?php

namespace Domain\Accounts\Listeners;

use Domain\Accounts\Models\Account;
use Illuminate\Auth\Events\Login;

class AccountLoginListener
{
    public function handle(Login $event)
    {
        if (get_class($event->user) === Account::class) {
            $event->user->setLastLogin();
        }
    }
}
