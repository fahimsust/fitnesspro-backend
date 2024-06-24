<?php

namespace Domain\Sites\Actions\PaymentMethods;

use App\Api\Admin\Sites\Requests\SubscriptionPaymentMethodRequest;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class RemoveSubscriptionPaymentMethodFromSite
{
    use AsObject;

    public function handle(
        Site $site,
        SubscriptionPaymentMethodRequest $request
    ): Collection {
        if (! GetSiteSubscriptionPaymentMethod::fromRequest($site, $request)) {
            throw new \Exception(__('Payment account not exists'));
        }

        $site->subscriptionPaymentMethods()->where(
            [
                'payment_method_id' => $request->payment_method_id,
                'gateway_account_id' => $request->gateway_account_id,
            ]
        )->delete();

        return $site->subscriptionPaymentMethods;
    }
}
