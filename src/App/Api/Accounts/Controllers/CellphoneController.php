<?php

namespace App\Api\Accounts\Controllers;

use App\Api\Accounts\Requests\UpdateAccountCellphoneRequest;
use Domain\Accounts\Models\Account;
use Support\Controllers\AbstractController;

class CellphoneController extends AbstractController
{
    /**
     * Display a listing of the resource.
     *
     * @param  Account  $account
     *
     * @return array
     */
    public function index(Account $account)
    {
        return ['cellphone' => $account->cellphone];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Account  $account
     * @param  UpdateAccountCellphoneRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Account $account, UpdateAccountCellphoneRequest $request): \Illuminate\Http\Response
    {
        $account->updateCellphone($request);

        return response(
            ['cellphone' => $account->fresh()->cellphone],
            '201'
        );
    }
}
