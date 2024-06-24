<?php

namespace Domain\Products\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class FailedOrderRuleCheck extends \Exception
{
    protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;
}
