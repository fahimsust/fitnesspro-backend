<?php

namespace App\Api\Accounts\Controllers\Registration;

use App\Api\Accounts\Requests\Registration\CompleteRegistrationOrderRequest;
use App\Api\Payments\Contracts\PaymentRequest;
use Domain\Accounts\Actions\Registration\IsRegistrationPaid;
use Domain\Accounts\Actions\Registration\LoadRegistrationById;
use Domain\Accounts\Actions\Registration\Order\CompleteOrderForRegistration;
use Domain\Accounts\Actions\Registration\Order\PlaceOrderForRegistration;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PayCompleteController extends AbstractController
{
    public function store(PaymentRequest $request)
    {
        $checkout = PlaceOrderForRegistration::now(
            LoadRegistrationById::now(
                session('registrationId')
            ),
            $request
        );

        return response(
            $checkout->jsonResponse(),
            $checkout->statusResponse()
        );
    }

    public function update(CompleteRegistrationOrderRequest $request)
    {
        return response(
            [
                'order' => CompleteOrderForRegistration::now(
                    LoadRegistrationById::now(
                        $request->registration_id
                    ),
                )
            ],
            Response::HTTP_CREATED
        );
    }

    public function show()
    {
        //return order's payment status
        $registration = LoadRegistrationById::run(
            session('registrationId')
        );

        return response(
            [
                'order' => $registration->orderCached(),
                'is_paid' => IsRegistrationPaid::now(
                    $registration
                )
            ],
            Response::HTTP_OK
        );
    }
}
