<?php

namespace App\Api\Discounts\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class DiscountCodeHasExpired extends \Exception
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(
            $message ? $message : __('Sorry, that discount code could not be used as it has expired.'),
            $code ? $code : Response::HTTP_NOT_FOUND,
            $previous
        );
    }
}
