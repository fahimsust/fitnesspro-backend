<?php

namespace App\Api\Admin\Addresses\Controllers;

use App\Api\Admin\Addresses\Requests\AddressSearchRequest;
use App\Api\Admin\Addresses\Requests\CreateAddressRequest;
use Domain\Addresses\Actions\CreateAddressFromAddressData;
use Domain\Addresses\Actions\UpdateAddressFromAddressData;
use Domain\Addresses\Models\Address;
use Domain\Addresses\QueryBuilders\AddressQuery;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AddressController extends AbstractController
{
    public function index(AddressSearchRequest $request)
    {
        return response(
            Address::query()
                ->when(
                    $request->filled('account_id'),
                    fn (AddressQuery $query) => $query->accountAddressSearch($request->account_id, $request->keyword),
                    fn (AddressQuery $query) => $query->accountWithoutAddressSearch($request->keyword)
                )->with('stateProvince', 'country')->get(),
            Response::HTTP_OK
        );
    }
    public function update(Address $address, CreateAddressRequest $request)
    {
        return response(
            UpdateAddressFromAddressData::run($request->getData(), $address),
            Response::HTTP_CREATED
        );
    }

    public function store(CreateAddressRequest $request)
    {
        return response(
            CreateAddressFromAddressData::run($request->getData()),
            Response::HTTP_CREATED
        );
    }

    public function show(Address $address)
    {
        return response(
            Address::whereId($address->id)->with('stateProvince', 'country')->first(),
            Response::HTTP_OK
        );
    }
}
