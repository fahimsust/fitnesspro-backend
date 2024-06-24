<?php

namespace Domain\Payments\Services\PaypalCheckout\Contracts;

interface PaypalEndpoint
{
    public static function baseUri(): string;
}
