<?php

namespace Domain\Accounts\Actions\Registration;

use App\Api\Accounts\Exceptions\CheckRegistration;
use App\Api\Accounts\Requests\Registration\RegistrationRecoveryRequest;
use Domain\Accounts\Actions\Registration\Mail\SendRecoveryEmail;
use Domain\Accounts\Models\Registration\Registration;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateRecoveryHashAndSendEmail
{
    use AsObject;

    public function handle(RegistrationRecoveryRequest $request): Registration
    {
        (new CheckRegistration(
            $registration = FindRegistrationByAccountEmail::run($request->email)
        ))->isOpen();

        SendRecoveryEmail::run(
            CreateRegistrationRecoveryHash::run($registration)
        );

        return $registration;
    }
}
