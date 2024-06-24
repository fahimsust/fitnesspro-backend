<?php

namespace App\Api\Accounts\Controllers\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Support\Controllers\AbstractController;

class ResetPasswordController extends AbstractController
{
    use ResetsPasswords;

    public function __invoke(Request $request)
    {
        return $this->reset($request);
    }

    public function broker()
    {
        return Password::broker('accounts');
    }

    protected function guard()
    {
        return Auth::guard('web');
    }

    protected function redirectTo()
    {
        return route('account.dashboard');
    }
}
