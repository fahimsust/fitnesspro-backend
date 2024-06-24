<?php

namespace App\Api\Accounts\Controllers\Auth\Firebase;

use App\Api\Accounts\Requests\AccountAuthenticateRequest;
use Domain\Accounts\Actions\AuthenticateAccount;
use Illuminate\Routing\Controller;
use Kreait\Firebase\Auth;
use function request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Auth  $auth
     *
     * @return \Illuminate\Http\Response
     */
//    public function index(Auth $auth)
//    {
//        //create custom token
    ////        $customToken = $auth->createCustomToken(request('uid'));
    ////
    ////        return ['token' => $customToken->toString()];
//    }

    /**
     * $auth = new Kreait
     * generate id token - not used currently
     *
     * @param  Auth  $auth
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Auth $auth)
    {
//        if(request('anon'))
//            $signIn = $auth->signInAnonymously();
//        else{
        //sign in with custom token
        $signIn = $auth->signInWithCustomToken(request('token'));
//        }

        return ['id_token' => $signIn->idToken()];
    }

    public function store(AccountAuthenticateRequest $request, Auth $auth)
    {
        $validated = $request->validated();
        $account = AuthenticateAccount::ByUser($validated['user'], $validated['pass']);

        //create custom token
        $customToken = $auth->createCustomToken((string) $account->id, ['is_account' => true]);

        return ['token' => $customToken->toString(), 'account_id' => $account->id];
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $idToken
     * @param  Auth  $auth
     *
     * @return \Illuminate\Http\Response
     */
    public function show(string $idToken, Auth $auth)
    {
        //verify id token
        $verify = $auth->verifyIdToken($idToken);

        $userId = $verify->claims()->get('user_id');
        $isAccount = $verify->claims()->get('is_account') === true;

        return ['verified' => $userId !== '' ? true : false, 'user_id' => $userId, 'is_account' => $isAccount];
    }
}
