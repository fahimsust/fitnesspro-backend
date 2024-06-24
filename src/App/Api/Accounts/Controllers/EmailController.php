<?php

namespace App\Api\Accounts\Controllers;

use App\Api\Accounts\Requests\UpdateAccountEmailRequest;
use Domain\Accounts\Models\Account;
use Support\Controllers\AbstractController;

class EmailController extends AbstractController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Account $account)
    {
        //return account's email address

        return ['email' => $account->email];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Account  $account
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Account $account, UpdateAccountEmailRequest $request)
    {
        $account->update(['email' => $request->new_email]);

        return response(['email' => $account->fresh()->email], 201);
    }
}
