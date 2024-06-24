<?php

namespace Domain\Payments\Enums;

use App\Api\Payments\Requests\CimPaymentProfileRequest;
use App\Api\Payments\Requests\PassivePaymentRequest;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Actions\Services\AuthorizeNet\ChargeAuthNetCimProfilePaymentServiceAction;
use Domain\Payments\Actions\Services\PayByCashOnDelivery;
use Domain\Payments\Actions\Services\PayByNet30;
use Domain\Payments\Actions\Services\PayByPhone;
use Domain\Payments\Actions\Services\PaypalCheckout\ChargePaypalOrderPaymentServiceAction;
use Domain\Payments\Contracts\PaymentServiceAction;
use Domain\Payments\Dtos\PaymentRequestData;
use Support\Dtos\RedirectUrl;

enum PaymentMethodActions: int
{
    case AuthorizeNetCim = 1;
    case AuthorizeNetAim = 5;

    case PaypalProExpress = 7;
    case PaypalProDirect = 8;

    case PayByPhone = 2;
    case CashOnDelivery = 3;
    case Net30 = 4;

    public function initiatePaymentRequest(
        PaymentRequestData $paymentRequestData,
    ): OrderTransaction|RedirectUrl|true
    {
        return $this->serviceAction($paymentRequestData)
            ->initiate();
    }

    public function confirmPaymentRequest(
        PaymentRequestData $paymentRequestData,
    ): OrderTransaction
    {
        return $this->serviceAction($paymentRequestData)
            ->confirm();
    }

    public function cancelPaymentRequest(
        PaymentRequestData $paymentRequestData,
    ): array
    {
        return $this->serviceAction($paymentRequestData)
            ->cancel();
    }

    protected function serviceAction(
        PaymentRequestData $paymentRequestData,
    ): PaymentServiceAction
    {
        return resolve(
            $this->serviceActionClass(),
            ['paymentRequestData' => $paymentRequestData]
        );
    }

    public function serviceActionClass(): string
    {
        return match ($this) {
            self::AuthorizeNetCim => ChargeAuthNetCimProfilePaymentServiceAction::class,
//            self::AuthorizeNetAim => \Domain\Payments\Services\AuthorizeNetAimService::class,
            self::PaypalProExpress => ChargePaypalOrderPaymentServiceAction::class,
//            self::PaypalProDirect => \Domain\Payments\Services\PaypalProDirectService::class,
            self::PayByPhone => PayByPhone::class,
            self::CashOnDelivery => PayByCashOnDelivery::class,
            self::Net30 => PayByNet30::class
        };
    }

//    public function serviceRequestClass(): string
//    {
//        return match ($this) {
//            self::AuthorizeNetCim => CimPaymentProfileRequest::class,
//
//
//            self::PayByPhone,
//            self::CashOnDelivery,
//            self::Net30 => PassivePaymentRequest::class,
//        };
//    }
}
