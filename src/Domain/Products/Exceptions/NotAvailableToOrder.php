<?php

namespace Domain\Products\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class NotAvailableToOrder extends \Exception
{
    protected $code = Response::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS;
}
