<?php

namespace Domain\Accounts\Actions\Registration;

use Domain\Accounts\Models\Registration\Registration;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateRegistrationRecoveryHash
{
    use AsObject;

    public function handle(Registration $registration): Registration
    {
        $registration->update([
            'recovery_hash' => Str::random(40) . $registration->id,
        ]);

        return $registration;
    }
}
