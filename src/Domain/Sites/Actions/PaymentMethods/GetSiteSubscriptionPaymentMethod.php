<?php

namespace Domain\Sites\Actions\PaymentMethods;

use App\Api\Admin\Sites\Requests\SubscriptionPaymentMethodRequest;
use Domain\Accounts\Models\Membership\SubscriptionPaymentOption;
use Domain\Sites\Models\Site;
use Lorisleiva\Actions\Concerns\AsObject;

class GetSiteSubscriptionPaymentMethod
{
    use AsObject;

    public function handle(
        Site $site,
        int $payment_method_id,
        int $gateway_account_id
    ): ?SubscriptionPaymentOption {
        return $site->subscriptionPaymentMethods()->where([
            'payment_method_id' => $payment_method_id,
            'gateway_account_id' => $gateway_account_id,
        ])->first();
    }

    public static function fromRequest(
        Site $site,
        SubscriptionPaymentMethodRequest $request
    ) {
        return self::run($site, $request->payment_method_id, $request->gateway_account_id);
    }
}
