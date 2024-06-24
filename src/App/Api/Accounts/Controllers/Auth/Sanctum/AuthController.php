<?php

namespace App\Api\Accounts\Controllers\Auth\Sanctum;

use function __;
use App\Api\Accounts\Requests\LoginRequest;
use Domain\Accounts\Exceptions\AccountLoginException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function response;
use Support\Controllers\AbstractController;

class AuthController extends AbstractController
{
    use AuthenticatesUsers;

    public function store(LoginRequest $request)
    {
        return $this->login($request);
    }

    public function destroy(Request $request)
    {
        return $this->logout($request);
    }

    public function username()
    {
        return 'username';
    }

    public function me(Request $request)
    {
        return response()->json([
            'data' => $request->user(),
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        return $request->wantsJson()
            ? new JsonResponse(['user' => $user], 200)
            : redirect(route('account.dashboard'));
    }

    protected function loggedOut(Request $request)
    {
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect(route('account.index'));
    }

    protected function guard()
    {
        return Auth::guard('web');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw new AccountLoginException(__('Invalid login details'));
    }
}
