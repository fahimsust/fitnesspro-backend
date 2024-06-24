<?php

namespace Domain\Payments\Services\PaypalCheckout\Enums;

enum PaymentStatuses: string
{
    case Created = 'CREATED';
    case Approved = 'APPROVED';
    case Voided = 'VOIDED';
    case Completed = 'COMPLETED';
    case Saved = 'SAVED';
    case PayerActionRequired = 'PAYER_ACTION_REQUIRED';
}
