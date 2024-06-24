<?php

namespace App\Api\Accounts\Controllers\Registration;

use App\Api\Accounts\Requests\Registration\CreateAccountFromBasicInfoRequest;
use Domain\Accounts\Actions\Registration\LoadRegistrationInFull;
use Domain\Accounts\Actions\Registration\StartRegistration;
use Domain\Accounts\ValueObjects\BasicAccountInfoData;
use Domain\Affiliates\Actions\CheckAffiliateCookie;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class StartController extends AbstractController
{
    public function store(CreateAccountFromBasicInfoRequest $request)
    {
        $starter = StartRegistration::run(
            site(),
            BasicAccountInfoData::fromRequest(
                $request,
                CheckAffiliateCookie::run()?->id
            ),
            session('registrationId')
        );

        session(['registrationId' => $starter->registration->id]);

        return response(
            $starter->resource(),
            Response::HTTP_CREATED
        );
    }

    public function show()
    {
        return response(
            LoadRegistrationInFull::run(
                session('registrationId')
            ),
            Response::HTTP_OK
        );
    }
}
