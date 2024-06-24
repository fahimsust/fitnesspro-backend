<?php

namespace Domain\Payments\Contracts;

use Domain\Payments\Dtos\TransactionDto;

interface NonJumpingPaymentAction
{
    public function charge(): TransactionDto|bool;
}
