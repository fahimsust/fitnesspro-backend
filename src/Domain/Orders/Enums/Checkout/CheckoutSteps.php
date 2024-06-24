<?php

namespace Domain\Orders\Enums\Checkout;

enum CheckoutSteps: string
{
    case Account = 'account';
    case BillingAddress = 'billing_address';
    case ShippingAddress = 'shipping_address';
    case ShippingMethodSelected = 'shipping_method_selected';
    case PaymentMethodSelected = 'payment_method_selected';
}
