<?php

namespace Domain\Accounts\Exceptions;

use Domain\Accounts\Models\Membership\Subscription;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class AutoRenewPaymentSetupException
    extends Exception
    implements HttpExceptionInterface
{
    public function __construct($message = "", $code = null, Throwable $previous = null)
    {
        parent::__construct(
            __("Invalid auto-renew payment setup: :error",
                ["error" => $message]
            ),
            $this->getStatusCode(),
            $previous
        );
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_UNPROCESSABLE_ENTITY;
    }

    public function getHeaders(): array
    {
        return [];
    }

    public static function CheckAutoRenewPaymentSettings(Subscription $membership)
    {
        self::CheckAutoRenewPaymentMethodSet($membership);
        self::CheckAutoRenewPaymentProfileSet($membership);
    }

    public static function CheckAutoRenewPaymentProfileSet(Subscription $membership)
    {
        if(!is_null($membership->renew_payment_profile_id))
            return;

        throw new static(__("Auto-renew payment profile is not set"));
    }

    public static function CheckAutoRenewPaymentMethodSet(Subscription $membership)
    {
        if(!is_null($membership->renew_payment_method))
            return;

        throw new static(__("Auto-renew payment method is not set"));
    }
}
