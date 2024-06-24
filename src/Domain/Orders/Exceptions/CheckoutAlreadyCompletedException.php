<?php

namespace Domain\Orders\Exceptions;

use Domain\Orders\Models\Checkout\Checkout;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class CheckoutAlreadyCompletedException extends Exception
{
    public static function check(Checkout $checkout)
    {
        if ($checkout->status->isCompleted()) {
            throw new static(
                'Checkout is already completed'
            );
        }
    }
}
