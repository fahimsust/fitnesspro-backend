<?php

namespace App\Api\Admin\Users\Controllers\Auth\Sanctum;

use function __;
use App\Api\Admin\Users\Requests\LoginRequest;
use Domain\AdminUsers\Exceptions\AdminLoginException;
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
        return Auth::guard('admin');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw new AdminLoginException(__('Invalid login details'));
    }
}
