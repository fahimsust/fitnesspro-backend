<?php

namespace Domain\Accounts\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class AccountLoginException extends Exception implements HttpExceptionInterface
{
    public function __construct($message = '', $code = null, ?Throwable $previous = null)
    {
        parent::__construct(__('Failed to login: :error', ['error' => $message]), $this->getStatusCode(), $previous);
    }

    public function getStatusCode(): int
    {
        return 401;
    }

    public function getHeaders(): array
    {
        return [];
    }
}
