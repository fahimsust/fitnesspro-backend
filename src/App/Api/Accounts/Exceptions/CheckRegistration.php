<?php

namespace App\Api\Accounts\Exceptions;

use function __;
use Domain\Accounts\Enums\RegistrationStatus;
use Domain\Accounts\Models\Registration\Registration;
use Symfony\Component\HttpFoundation\Response;

class CheckRegistration
{
    public function __construct(
        public Registration $registration
    ) {
    }

    public function isOpen(): static
    {
        if (RegistrationStatus::IsOpen($this->registration)) {
            return $this;
        }

        throw new \Exception(
            __('Registration has already been completed'),
            Response::HTTP_NOT_FOUND
        );
    }
}
