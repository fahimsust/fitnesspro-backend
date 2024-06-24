<?php

namespace App\Api\Orders\Exceptions\Cart;

use Support\Exceptions\Httpable;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ItemQtyAdjustedWarning extends \Exception implements HttpExceptionInterface
{
    use Httpable;
}
