<?php

namespace Domain\Payments\Services\PaypalCheckout\Enums;

enum ProcessingInstructions: string
{
    case OrderCompleteOnApproval = 'ORDER_COMPLETE_ON_PAYMENT_APPROVAL';
    case NoInstructions = 'NO_INSTRUCTION';
}
