<?php

namespace App\Api\Orders\Exceptions\Cart;

use Support\Exceptions\Httpable;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class CartDoesNotMatchAccount extends \Exception implements HttpExceptionInterface
{
    use Httpable;

    protected $message = 'Cart does not match your account';

    protected int $statusCode = Response::HTTP_FORBIDDEN;
}
