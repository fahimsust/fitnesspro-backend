<?php

namespace App\Api\Accounts\Controllers\Auth;

use App\Api\Accounts\Requests\FindAccountByEmailRequest;
use Domain\Accounts\Jobs\SendForgotUsernameEmail;
use Domain\Accounts\Mail\AccountForgotUsername;
use Domain\Accounts\Models\Account;
use Domain\Sites\Models\Site;
use Support\Controllers\AbstractController;

class ForgotUsernameController extends AbstractController
{
    public function __invoke(FindAccountByEmailRequest $request)
    {
        $account = Account::FindByEmail($request['email']);
        Site::SendMailable(new AccountForgotUsername($account));

        return ['username' => $account->user];
    }

    //    public function resetPassword(FindAccountByUsernameAndEmail $request)
    //    {
    //        $account = Account::FindByUsernameAndEmail($request['email'], $request['user']);
    //        $resetPassword = $account->resetPassword();
    //
    //        Site::SendMailable(new AccountForgotPassword($account, $resetPassword));
    //
    //        return ['password' => $resetPassword];
    //    }
}
