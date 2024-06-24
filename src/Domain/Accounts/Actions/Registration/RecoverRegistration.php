<?php

namespace Domain\Accounts\Actions\Registration;

use App\Api\Accounts\Exceptions\CheckRegistration;
use Domain\Accounts\Models\Registration\Registration;
use Lorisleiva\Actions\Concerns\AsObject;

class RecoverRegistration
{
    use AsObject;

    public function handle(string $recoveryHash): Registration
    {
        return (new CheckRegistration(
            Registration::withAllRelations()
                ->whereRecoveryHash($recoveryHash)
                ->firstOrFail()
        ))
            ->isOpen()
            ->registration;
    }
}
