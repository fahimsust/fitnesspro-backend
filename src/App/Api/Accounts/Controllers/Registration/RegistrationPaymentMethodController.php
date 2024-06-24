<?php

namespace App\Api\Accounts\Controllers\Registration;

use App\Api\Accounts\Requests\Registration\RegistrationPaymentMethodRequest;
use Domain\Accounts\Actions\Registration\SetRegistrationPaymentMethod;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Payments\Models\PaymentMethod;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RegistrationPaymentMethodController extends AbstractController
{
    public function index()
    {
        return response(
            PaymentMethod::active()
                ->forSubscription(config('site.id'))
                ->get()
        );
    }

    public function store(RegistrationPaymentMethodRequest $request)
    {
        return response(
            SetRegistrationPaymentMethod::run($request, session('registrationId')),
            Response::HTTP_CREATED
        );
    }

    public function show()
    {
        //todo return expected fields for request
        return response(
            Registration::findOrFail(session('registrationId'))->paymentMethod
        );
    }
}
