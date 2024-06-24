<?php

namespace App\Api\Orders\Resources\Checkout;

use App\Api\Orders\Resources\Cart\CartResource;
use App\Api\Orders\Resources\Order\OrderResource;
use Domain\Orders\Models\Checkout\Checkout;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckoutResource extends JsonResource
{
    private Request $request;

    public function toArray($request)
    {
        /** @var Checkout $checkout */
        $checkout = $this->resource;
        $this->request = $request;

        return [
                'id' => $checkout->id,
                'uuid' => $checkout->uuid,
                'status' => $checkout->status->label(),
                'comments' => $checkout->comments,
                'account' => $checkout->account_id
                    ? new AccountResource($checkout->accountCached())
                    : null,
                'order' => $checkout->order_id
                    ? new OrderResource($checkout->orderCached())
                    : null,
                'affiliate' => $checkout->affiliate_id
                    ? new AffiliateResource($checkout->affiliateCached())
                    : null,
                'cart' => new CartResource(
                    $checkout->cartCached(),
                ),
                'billing_address' => $checkout->billingAddressCached(),
                'shipping_address' => $checkout->shippingAddressCached(),
                'payment_method' => $this->requestHas(
                    'include_payment_method',
                    fn() => $checkout->paymentMethodCached(),
                ),
                'site' => $this->requestHas(
                    'include_site',
                    fn() => $checkout->siteCached(),
                ),
                'shipments' => $this->requestHas(
                    'include_shipments',
                    fn() => $checkout->shipmentsCached(),
                ),
            ]
            +
            $this->request->whenHas(
                'include_shipments',
                fn() => [
                    'subtotal' => $checkout->cartCached()->subTotal(),
                    'tax_total' => $checkout->taxTotal(),
                    'shipping_total' => $checkout->shippingCost(),
                    'discount_total' => $checkout->cartCached()->discountTotal(),
                    'total' => $checkout->total(),
                ],
                fn() => []
            );
    }

    private function requestHas(
        string   $key,
        callable $callback,
    ): mixed
    {
        return $this->request->whenHas(
            $key,
            $callback,
            fn() => null,
        );
    }
}
