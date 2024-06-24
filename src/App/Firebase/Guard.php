<?php

namespace App\Firebase;

use Domain\Accounts\Models\Account;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Kreait\Firebase\Auth;

class Guard
{

    public ?\Lcobucci\JWT\Token $verify = null;
    /**
     * @var Auth
     */
    private Auth $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function user(Request $request)
    {
        return $this->getUser($request);
    }

    private function getUser($request)
    {
        $this->verifyToken($request);

        $accountId = $this->verify->claims()->get('user_id');
        $isAccount = $this->verify->claims()->get('is_account') === true;

        if (! $isAccount) {//verfied but not an account - anon/app user
            return new App($accountId);
        }

        $account = Account::find($accountId);
        $account->isActiveOrThrow();

        return new User($account);
    }

    private function verifyToken($request)
    {
//        if(env('APP_ENV') == 'testing')
//            return $request->bearerToken();

        if (Str::length($request->bearerToken()) < 50) {
            throw new AuthenticationException(__('Invalid bearer token'));
        }

        try {
            return $this->verify = $this->auth->verifyIdToken($request->bearerToken());
        } catch (\Exception $e) {
            throw new \Exception(__('Failed to verify bearer token: :error', ['error' => $e->getMessage()]));
        }
    }
}
