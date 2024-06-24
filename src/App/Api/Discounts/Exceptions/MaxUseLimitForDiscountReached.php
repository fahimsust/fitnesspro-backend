<?php

namespace App\Api\Discounts\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class MaxUseLimitForDiscountReached extends \Exception
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(
            $message ? $message : __("Sorry, you've reached the limit for the number of times you can use that discount code."),
            $code ? $code : Response::HTTP_NOT_FOUND,
            $previous
        );
    }
}
