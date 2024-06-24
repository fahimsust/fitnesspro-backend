<?php

namespace Domain\Accounts\Exceptions;


use Domain\Accounts\Models\Cim\CimPaymentProfile;
use Exception;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class CreditCardException
    extends Exception
    implements HttpExceptionInterface
{
    public function __construct($message = "", $code = null, Throwable $previous = null)
    {
        parent::__construct(
            __("Credit card error: :error",
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

    public static function CheckIfExpiresBefore(
        CimPaymentProfile $paymentProfile,
        Carbon            $expiration
    )
    {
        if ($paymentProfile->cc_exp >= $expiration->format("Y-m-d"))
            return;

        $format = "M jS, Y";

        throw new static(__("Card expires :on before :date renewal", [
            'on' => Carbon::createFromFormat("Y-m-d H:i:s", $paymentProfile->cc_exp)->format($format),
            'date' => $expiration->format($format)
        ]));
    }
}
