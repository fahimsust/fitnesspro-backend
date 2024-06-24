<?php

namespace App\Api\Admin\AccountType\Controllers;

use App\Api\Admin\AccountType\Requests\AccountTypeRequest;
use Domain\Accounts\Actions\AccountType\CreateAccountType;
use Domain\Accounts\Actions\AccountType\UpdateAccountType;
use Domain\Accounts\Models\AccountType;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AccountTypeController extends AbstractController
{
    public function index()
    {
        return response(
            AccountType::orderBy('name')->get(),
            Response::HTTP_OK
        );
    }
    public function update(AccountType $accountType, AccountTypeRequest $request)
    {
        return response(
            UpdateAccountType::run($accountType, $request),
            Response::HTTP_CREATED
        );
    }
    public function store(AccountTypeRequest $request)
    {
        return response(
            CreateAccountType::run($request),
            Response::HTTP_CREATED
        );
    }
}
