<?php

namespace App\Api\Orders\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class MaxDiscountsPerOrderReached extends \Exception
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(
            $message ? $message : __("You've already reached the limit of discount codes that can be applied per order."),
            $code ? $code : Response::HTTP_PRECONDITION_FAILED,
            $previous
        );
    }
}
