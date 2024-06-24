<?php

namespace App\Api\Accounts\Controllers;

use Domain\Accounts\Models\Account;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;

class AccountController extends AbstractController
{
    /**
     * Display a listing of the resource.
     *
     * @return array<Account>|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
//        return ['accounts' => Account::paginate(100)];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    public function show(Account $account)
    {
        $account->load([
            'activeMembership',
            'profilePhoto',
            'status',
            'type',
            'defaultBillingAddress',
            'defaultShippingAddress',
            'approvedSpecialties',
        ])->append('cellphone');

        return ['account' => $account];
    }
}
