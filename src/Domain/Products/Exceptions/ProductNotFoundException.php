<?php

namespace Domain\Products\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class ProductNotFoundException extends Exception implements HttpExceptionInterface
{
    public function __construct($message = '', $code = null, ?Throwable $previous = null)
    {
        parent::__construct(__('Product not found: :error', ['error' => $message]), $this->getStatusCode(), $previous);
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
