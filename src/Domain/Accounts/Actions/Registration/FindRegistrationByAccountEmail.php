<?php

namespace Domain\Accounts\Actions\Registration;

use Domain\Accounts\Models\Registration\Registration;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Lorisleiva\Actions\Concerns\AsObject;
use Symfony\Component\HttpFoundation\Response;

class FindRegistrationByAccountEmail
{
    use AsObject;

    public function handle(string $email): ?Registration
    {
        return Registration::whereHas(
            'account',
            fn ($query) => $query->whereEmail($email)
        )->first()
            ?? throw new ModelNotFoundException(
                __('Registration not found for email :email', [
                    'email' => $email,
                ]),
                Response::HTTP_NOT_FOUND
            );
    }
}
