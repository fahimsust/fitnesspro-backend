<?php

namespace App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\CheckoutPaymentMethodRequest;
use Domain\Sites\Actions\PaymentMethods\AddCheckoutPaymentMethod;
use Domain\Sites\Actions\PaymentMethods\RemoveCheckoutPaymentMethod;
use Domain\Sites\Actions\PaymentMethods\UpdateCheckoutPaymentMethod;
use Domain\Sites\Models\Site;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CheckoutPaymentMethodController extends AbstractController
{
    public function index(Site $site)
    {
        return response(
            $site->checkoutPaymentMethods->each->load('paymentAccount.gateway','paymentMethod'),
            Response::HTTP_OK
        );
    }

    public function store(Site $site, CheckoutPaymentMethodRequest $request)
    {
        return response(
            AddCheckoutPaymentMethod::run($site, $request),
            Response::HTTP_CREATED
        );
    }
    public function update(Site $site, CheckoutPaymentMethodRequest $request)
    {
        return response(
            UpdateCheckoutPaymentMethod::run($site, $request),
            Response::HTTP_CREATED
        );
    }

    public function destroy(Site $site, CheckoutPaymentMethodRequest $request)
    {
        return response(
            RemoveCheckoutPaymentMethod::run($site, $request),
            Response::HTTP_OK
        );
    }
}
