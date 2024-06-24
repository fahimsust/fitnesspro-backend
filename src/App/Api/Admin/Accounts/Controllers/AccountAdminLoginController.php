<?php

namespace App\Api\Admin\Accounts\Controllers;

use App\Api\Admin\Accounts\Requests\AccountLoginRequest;
use Domain\Accounts\Models\Account;
use Support\Controllers\AbstractController;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AccountAdminLoginController extends AbstractController
{
    public function store(AccountLoginRequest $request)
    {
        $account = Account::find($request->account_id);
        Auth::guard('web')->login($account);
        return response(
            [],
            Response::HTTP_OK
        );
    }
}
