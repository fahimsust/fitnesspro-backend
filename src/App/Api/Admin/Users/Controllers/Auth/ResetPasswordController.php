<?php

namespace App\Api\Admin\Users\Controllers\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use function route;
use Support\Controllers\AbstractController;

class ResetPasswordController extends AbstractController
{
    use ResetsPasswords;

//    public function index(Request $request)
//    {
//        //showResetForm
//        return view('account.passwords.reset', [
//            'title' => __('Password Reset'),
//            'formRoute' => 'account.reset-password.store'
//        ])->with([
//            'token' => request('token'),
//            'email' => $request->email
//        ]);
//    }

    public function __invoke(Request $request)
    {
        return $this->reset($request);
    }

    public function broker()
    {
        return Password::broker('users');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected function redirectTo()
    {
        return route('admin.dashboard');
    }
}
