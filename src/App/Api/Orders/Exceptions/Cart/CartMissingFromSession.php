<?php

namespace App\Api\Orders\Exceptions\Cart;

use function __;
use App\Api\Orders\Exceptions\Throwable;
use Symfony\Component\HttpFoundation\Response;

class CartMissingFromSession extends \Exception
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(
            $message ? $message : __('No cart exists in session'),
            $code ? $code : Response::HTTP_NOT_FOUND,
            $previous
        );
    }
}
