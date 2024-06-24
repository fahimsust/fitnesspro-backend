<?php

namespace App\Api\Accounts\Controllers\Registration;

use App\Api\Accounts\Requests\Registration\AssignAffiliateToRegistrationRequest;
use Domain\Accounts\Actions\Registration\AssignAffiliateToRegistration;
use Domain\Accounts\Models\Registration\Registration;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RegistrationAffiliateController extends AbstractController
{
    public function store(AssignAffiliateToRegistrationRequest $request)
    {
        return response(
            AssignAffiliateToRegistration::run($request,session('registrationId')),
            Response::HTTP_CREATED
        );
    }

    public function show()
    {
        return response(
            Registration::findOrFail(session('registrationId'))->affiliate
        );
    }
}
