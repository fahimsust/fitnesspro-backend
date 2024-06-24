<?php

namespace Domain\Affiliates\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class AffiliateNotFoundException extends Exception implements HttpExceptionInterface
{
    public function __construct($message = '', $code = null, ?Throwable $previous = null)
    {
        parent::__construct(__('Affiliate not found: :error', ['error' => $message]), $this->getStatusCode(), $previous);
    }

    public function getStatusCode(): int
    {
        return 404;
    }

    public function getHeaders(): array
    {
        return [];
    }
}
