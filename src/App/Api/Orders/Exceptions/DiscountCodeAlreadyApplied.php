<?php

namespace App\Api\Orders\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class DiscountCodeAlreadyApplied extends \Exception
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(
            $message ? $message : __('That discount code is already applied.'),
            $code ? $code : Response::HTTP_PRECONDITION_FAILED,
            $previous
        );
    }
}
