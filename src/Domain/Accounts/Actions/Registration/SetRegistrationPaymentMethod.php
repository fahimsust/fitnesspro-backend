<?php

namespace Domain\Accounts\Actions\Registration;

use App\Api\Accounts\Requests\Registration\RegistrationPaymentMethodRequest;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Payments\Models\PaymentMethod;
use Lorisleiva\Actions\Concerns\AsObject;

class SetRegistrationPaymentMethod
{
    use AsObject;

    public function handle(
        RegistrationPaymentMethodRequest $request,
        int                              $registration_id
    ): PaymentMethod
    {
        $paymentMethod = PaymentMethod::subscriptionOptions(config('site.id'))
            ->findOrFail($request->payment_method_id);

        Registration::findOrFail($registration_id)
            ->update(['payment_method_id' => $request->payment_method_id]);

        return $paymentMethod;
    }
}
