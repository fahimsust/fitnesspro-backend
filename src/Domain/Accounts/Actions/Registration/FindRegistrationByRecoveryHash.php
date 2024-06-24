<?php

namespace Domain\Accounts\Actions\Registration;

use Domain\Accounts\Models\Registration\Registration;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Lorisleiva\Actions\Concerns\AsObject;
use Symfony\Component\HttpFoundation\Response;

class FindRegistrationByRecoveryHash
{
    use AsObject;

    public function handle(string $hash): ?Registration
    {
        return Registration::whereRecoveryHash($hash)->first()
            ?? throw new ModelNotFoundException(
                __('Registration not found for hash'),
                Response::HTTP_NOT_FOUND
            );
    }
}
