<?php

namespace Domain\Payments\Actions\Services;

use Domain\Payments\Contracts\NonJumpingPaymentAction;
use Domain\Payments\Contracts\PaymentServiceAction;
use Domain\Payments\Traits\IsPassivePaymentAction;

class PayByCashOnDelivery
    extends PaymentServiceAction
    implements NonJumpingPaymentAction
{
    use IsPassivePaymentAction;
}
