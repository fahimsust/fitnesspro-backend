<?php

namespace Domain\Sites\Actions\PaymentMethods;

use App\Api\Admin\Sites\Requests\CheckoutPaymentMethodRequest;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SitePaymentMethod;
use Lorisleiva\Actions\Concerns\AsObject;

class GetCheckoutPaymentMethod
{
    use AsObject;

    public function handle(
        Site $site,
        int $payment_method_id,
        int $gateway_account_id
    ): ?SitePaymentMethod {
        return $site->checkoutPaymentMethods()->where([
            'payment_method_id' => $payment_method_id,
            'gateway_account_id' => $gateway_account_id,
        ])->first();
    }

    public static function fromRequest(
        Site $site,
        CheckoutPaymentMethodRequest $request
    ) {
        return self::run($site, $request->payment_method_id, $request->gateway_account_id);
    }
}
