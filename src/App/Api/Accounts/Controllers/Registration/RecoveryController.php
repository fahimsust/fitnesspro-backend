<?php

namespace App\Api\Accounts\Controllers\Registration;

use App\Api\Accounts\Requests\Registration\RegistrationRecoveryRequest;
use Domain\Accounts\Actions\Registration\CreateRecoveryHashAndSendEmail;
use Domain\Accounts\Actions\Registration\RecoverRegistration;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RecoveryController extends AbstractController
{
    public function store(RegistrationRecoveryRequest $request)
    {
        return response(
            CreateRecoveryHashAndSendEmail::run($request),
            Response::HTTP_CREATED
        );
    }

    public function show(string $recoveryHash)
    {
        $registration = RecoverRegistration::run($recoveryHash);

        session(['registrationId' => $registration->id]);

        return response(
            $registration,
            Response::HTTP_FOUND
        );
    }
}
