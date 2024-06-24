<?php

namespace App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\SubscriptionPaymentMethodRequest;
use Domain\Sites\Actions\PaymentMethods\AddSubscriptionPaymentMethodToSite;
use Domain\Sites\Actions\PaymentMethods\RemoveSubscriptionPaymentMethodFromSite;
use Domain\Sites\Models\Site;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionPaymentMethodController extends AbstractController
{
    public function index(Site $site)
    {
        return response(
            $site->subscriptionPaymentMethods->each->load('paymentAccount.gateway','paymentMethod'),
            Response::HTTP_OK
        );
    }

    public function store(Site $site, SubscriptionPaymentMethodRequest $request)
    {
        return response(
            AddSubscriptionPaymentMethodToSite::run($site, $request),
            Response::HTTP_CREATED
        );
    }

    public function destroy(Site $site, SubscriptionPaymentMethodRequest $request)
    {
        return response(
            RemoveSubscriptionPaymentMethodFromSite::run($site, $request),
            Response::HTTP_OK
        );
    }
}
