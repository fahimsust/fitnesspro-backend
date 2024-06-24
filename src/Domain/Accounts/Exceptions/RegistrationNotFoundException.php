<?php

namespace Domain\Accounts\Exceptions;


use Domain\Accounts\Models\Cim\CimPaymentProfile;
use Exception;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class RegistrationNotFoundException extends Exception
{
    public function __construct($message = "", $code = null, Throwable $previous = null)
    {
        parent::__construct(
            __("Registration not found: :error",
                ["error" => $message]
            ),
            $this->getStatusCode(),
            $previous
        );
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
