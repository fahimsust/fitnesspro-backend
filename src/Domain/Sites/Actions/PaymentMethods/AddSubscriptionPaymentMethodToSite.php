<?php

namespace Domain\Sites\Actions\PaymentMethods;

use App\Api\Admin\Sites\Requests\SubscriptionPaymentMethodRequest;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class AddSubscriptionPaymentMethodToSite
{
    use AsObject;

    public function handle(
        Site $site,
        SubscriptionPaymentMethodRequest $request
    ): Collection {
        if (GetSiteSubscriptionPaymentMethod::fromRequest($site, $request)) {
            throw new \Exception(__('Payment account already exists'));
        }

        $site->subscriptionPaymentMethods()->create(
            [
                'payment_method_id' => $request->payment_method_id,
                'gateway_account_id' => $request->gateway_account_id,
            ]
        );

        return $site->subscriptionPaymentMethods;
    }
}
