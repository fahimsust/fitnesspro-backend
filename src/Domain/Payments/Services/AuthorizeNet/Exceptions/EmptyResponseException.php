<?php

namespace Domain\Payments\Services\AuthorizeNet\Exceptions;

class EmptyResponseException extends \Exception
{
    protected $message = "Empty API response";
}
