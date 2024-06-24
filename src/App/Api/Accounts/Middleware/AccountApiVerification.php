<?php

namespace App\Api\Accounts\Middleware;

use Closure;
use Domain\Accounts\Models\Account;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountApiVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $account = $request->route('account');
        if (is_a($account, Account::class)) {//if account is set in route
            if (Auth::user()->getAuthIdentifierName() === 'app') {
                throw new AuthenticationException('You cannot access account-specific API endpoints');
            }

            if ($account->id !== Auth::user()->getAuthIdentifier()) {//make sure account matches authed api account
                throw new AuthenticationException('Account does not match token');
            }
        }

        return $next($request);
    }
}
