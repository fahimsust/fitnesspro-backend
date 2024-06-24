<?php

namespace App\Api\Discounts\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class DiscountCodeNotFound extends \Exception
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(
            $message ? $message : __('Sorry, that discount code could not be found in our system.  Please check to ensure the code is accurate and try again.'),
            $code ? $code : Response::HTTP_NOT_FOUND,
            $previous
        );
    }
}
