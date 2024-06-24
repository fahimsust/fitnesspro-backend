<?php

namespace Domain\Payments\Enums;

enum FrontendPaymentActions: string
{
    case Confirm = 'confirm';
    case Cancel = 'cancel';
    case Error = 'error';
}
