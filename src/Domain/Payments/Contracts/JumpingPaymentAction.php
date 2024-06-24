<?php

namespace Domain\Payments\Contracts;

use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Support\Dtos\RedirectUrl;

interface JumpingPaymentAction
{
    public function jump(): RedirectUrl;

    public function confirm(): OrderTransaction;

    public function cancel(): array;
}
