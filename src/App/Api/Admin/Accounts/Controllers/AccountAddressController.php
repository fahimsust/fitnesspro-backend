<?php

namespace App\Api\Admin\Accounts\Controllers;


use App\Api\Admin\Accounts\Requests\AccountAddressRequest;
use App\Api\Admin\Accounts\Requests\CreateAccountAddressRequest;
use Domain\Accounts\Actions\CreateAccountAddress;
use Domain\Accounts\Actions\UpdateAccountAddress;
use Domain\Accounts\Models\AccountAddress;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AccountAddressController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            AccountAddress::where('account_id', $request->account_id)
                ->where('status', '>=', $request->status ? $request->status : 0)
                ->orderBy('id', 'DESC')
                ->with('address')
                ->get(),
            Response::HTTP_OK
        );
    }
    public function update(AccountAddress $accountAddress, AccountAddressRequest $request)
    {
        return response(
            UpdateAccountAddress::run($request, $accountAddress),
            Response::HTTP_CREATED
        );
    }
    public function store(CreateAccountAddressRequest $request)
    {
        return response(
            CreateAccountAddress::run($request),
            Response::HTTP_CREATED
        );
    }
    public function destroy(AccountAddress $accountAddress)
    {
        return response(
            $accountAddress->update(['status' => $accountAddress->status == -1 ? 1 : -1]),
            Response::HTTP_CREATED
        );
    }
}
