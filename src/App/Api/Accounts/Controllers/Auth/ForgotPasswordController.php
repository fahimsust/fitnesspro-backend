<?php

namespace App\Api\Accounts\Controllers\Auth;

use App\Api\Accounts\Requests\ForgotPasswordRequest;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Support\Controllers\AbstractController;

class ForgotPasswordController extends AbstractController
{
    use SendsPasswordResetEmails;

    public function __invoke(ForgotPasswordRequest $request)
    {
        return $this->sendResetLinkEmail($request);
    }

    public function broker()
    {
        return Password::broker('accounts');
    }
}
