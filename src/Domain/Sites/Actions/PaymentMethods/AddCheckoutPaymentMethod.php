<?php

namespace Domain\Sites\Actions\PaymentMethods;

use App\Api\Admin\Sites\Requests\CheckoutPaymentMethodRequest;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class AddCheckoutPaymentMethod
{
    use AsObject;

    public function handle(
        Site $site,
        CheckoutPaymentMethodRequest $request
    ): Collection {
        if (GetCheckoutPaymentMethod::fromRequest($site, $request)) {
            throw new \Exception(__('Checkout payment method already exists'));
        }

        $site->checkoutPaymentMethods()->updateOrCreate(
            [
                'payment_method_id' => $request->payment_method_id,
                'gateway_account_id' => $request->gateway_account_id,
            ],
            [
                'fee'=>$request->fee,
            ]
        );

        return $site->checkoutPaymentMethods;
    }
}
