<?php

namespace App\Api\Orders\Resources\Order;

use Domain\Orders\Models\Order\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class OrderResource extends JsonResource
{
    private Request $request;

    public function toArray($request)
    {
        /** @var Order $order */
        $order = $this->resource;
        $this->request = $request;

        return [
            'id' => $order->id,
            'number' => $order->order_no,
            'payment_status' => $order->payment_status->label(),
            'status' => $order->status->label(),
            'phone' => $order->order_phone,
            'email' => $order->order_email,
            'comments' => $order->comments,
            'payment_method_fee' => $order->payment_method_fee,
            'addtl_fee' => $order->addtl_fee,
            'addtl_discount' => $order->addtl_discount,
            'account' => $this->requestHas(
                'include_account',
                fn () => $order->accountCached(),
            ),
            'affiliate' => $this->requestHas(
                'include_affiliate',
                fn () => $order->affiliateCached(),
            ),
            'billing_address' => $this->requestHas(
                'include_billing_address',
                fn () => $order->billingAddressCached(),
            ),
            'shipping_address' => $this->requestHas(
                'include_shipping_address',
                fn () => $order->shippingAddressCached(),
            ),
            'payment_method' => $this->requestHas(
                'include_payment_method',
                fn () => $order->paymentMethodCached(),
            ),
            'items' => $this->requestHas(
                'include_items',
                fn () => $this->loadItems(),
            ),
            'discounts' => $this->requestHas(
                'include_discounts',
                fn () => $this->loadDiscounts()
            ),
            'notes' => $this->requestHas(
                'include_notes',
                fn () => $order->notes()->paginate(
                    page: $this->request->get('notes_page', 1)
                ),
            ),
            'site' => $this->requestHas(
                'include_site',
                fn () => $order->siteCached(),
            ),
            'transactions' => $this->requestHas(
                'include_transactions',
                fn () => $order->transactionsCached(),
            ),
            'shipments' => $this->requestHas(
                'include_shipments',
                fn () => $this->loadShipments(),
            ),
        ]
            +
            $this->request->whenHas(
                'include_shipments',
                fn () => [
                    'subtotal' => $order->subtotal(),
                    'tax_total' => $order->taxTotal(),
                    'shipping_total' => $order->shippingTotal(),
                    'discount_total' => $order->discountTotal(),
                    'total' => $order->total(),
                ],
                fn () => []
            );
    }

    private function requestHas(
        string   $key,
        callable $callback,
    ): mixed {
        return $this->request->whenHas(
            $key,
            $callback,
            fn () => null,
        );
    }

    protected function loadDiscounts(): Collection
    {
        $discounts = $this->resource->discounts()
            ->when(
                $this->request->has('discount_relations'),
                fn ($query) => $query->with(
                    $this->request->get('discount_relations')
                )
            )
            ->get();

        $this->resource->setRelation('discounts', $discounts);

        return $discounts;
    }

    protected function loadItems(): Collection
    {
        $items = $this->resource->items()
            ->with([
                'orderItemDiscounts'
            ])
            ->when(
                $this->request->has('item_relations'),
                fn ($query) => $query->with(
                    $this->request->get('item_relations')
                )
            )
            ->get();

        $this->resource->setRelation('items', $items);

        return $items;
    }

    protected function loadShipments(): Collection
    {
        $shipments = $this->resource
            ->shipments()
            ->with([
                'registry',
                'shippingMethod',
                'packages' => fn ($query) => $query->with([
                    'items' => fn ($query) => $query->with(
                        'registryItem',
                        'customFields',
                        'tripFlyer',
                        'customs',
                        'discounts',
                        'optionValues',
                        'product',
                        'orderItemDiscounts'
                    )
                ]),
            ])
            ->when(
                $this->request->has('shipment_relations'),
                fn ($query) => $query->with(
                    $this->request->get('shipment_relations')
                )
            )
            ->get();

        $this->resource->setRelation('shipments', $shipments);

        return $shipments;
    }
}
