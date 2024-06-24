<?php

namespace App\Api\Accounts\Controllers\Registration;

use App\Api\Accounts\Requests\Registration\AccountAddressIdRequest;
use App\Api\Accounts\Requests\Registration\CreateAccountAddressRequest;
use Domain\Accounts\Actions\AccountAddresses\AssignDefaultAccountBillingAddress;
use Domain\Accounts\Actions\AccountAddresses\CreateAssignDefaultBillingAddressToAccount;
use Domain\Accounts\DataTransferObjects\AccountAddressDto;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountAddress;
use Domain\Accounts\Models\Registration\Registration;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RegistrationBillingAddressController extends AbstractController
{
    public function index()
    {
        return response(Registration::findOrFail(session('registrationId'))->account->billingAddresses->each->load('country','stateProvince'));
    }

    public function store(CreateAccountAddressRequest $request)
    {
        return response(
            CreateAssignDefaultBillingAddressToAccount::run(
                Registration::findOrFail(session('registrationId'))->account,
                AccountAddressDto::fromRequest($request)
            ),
            Response::HTTP_CREATED
        );
    }

    public function show()
    {
        return response(Registration::findOrFail(session('registrationId'))->account->defaultBillingAddress);
    }

    public function update(AccountAddressIdRequest $request)
    {
        return response(
            AssignDefaultAccountBillingAddress::run(
                Registration::findOrFail(session('registrationId'))->account,
                AccountAddress::whereBelongsTo(Registration::findOrFail(session('registrationId'))->account)->findOrFail($request->address_id)
            )->defaultBillingAddress,
            Response::HTTP_CREATED
        );
    }
}
