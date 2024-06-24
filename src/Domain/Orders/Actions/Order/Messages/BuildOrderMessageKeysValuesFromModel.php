<?php

namespace Domain\Orders\Actions\Order\Messages;

use Domain\Messaging\Enums\OrderMessageKeys;
use Domain\Orders\Models\Order\Order;
use Support\Contracts\AbstractAction;

class BuildOrderMessageKeysValuesFromModel extends AbstractAction
{
    public array $keys = [];

    public function __construct(
        public Order $order
    ) {
        $this->order->loadMissing([
            'shipments' => function ($query) {
                $query->orderBy('id', "desc");
            },
            'shipments.packages' => function ($query) {
                $query->orderBy('id', "desc");
            },
            'shipments.packages.items' => function ($query) {
                $query->orderBy('id', "desc");
            },
            'account',
            'billingAddress',
            'shippingAddress',
            'shipments.packages.items.options'
        ]);
    }

    public function execute(): array
    {
        $itemBuilder = BuildMessageItemListFromOrder::now($this->order);
        $detailsBuilder = BuildMessageDetailsFromOrder::now($this->order, $itemBuilder);

        $this
            ->addKeysFromBuilders($itemBuilder, $detailsBuilder)
            ->addAddressKeys()
            ->addDiscountKeys()
            ->addFeeKeys()
            ->addTotalKeys()
            ->addCommentKeys()
            ->addCustomerKeys();

        $this->addRemainingKeys();

        return $this->keys;
    }

    protected function addKeysFromBuilders(BuildMessageItemListFromOrder $itemBuilder, BuildMessageDetailsFromOrder $detailsBuilder): static
    {
        $this
            ->addKey('products_list', $itemBuilder->plainText)
            ->addKey('products_list_html', $itemBuilder->html)
            ->addKey('order_summary_display', $detailsBuilder->plainText)
            ->addKey('order_summary_display_html', $detailsBuilder->html)
            ->addKey('order_summary_html', $detailsBuilder->html);

        return $this;
    }

    protected function addAddressKeys(): static
    {
        $this
            ->addKey('bill_address_full', $this->order->billingAddress->streetPlainText())
            ->addKey('bill_address_full_html', $this->order->billingAddress->streetHtml())
            ->addKey('billing_address_printout', $this->order->billingAddress->fullPlainText())
            ->addKey('billing_address_printout_html', $this->order->billingAddress->fullHtml())
            ->addKey('ship_address_full', $this->order->shippingAddress->streetPlainText())
            ->addKey('ship_address_full_html', $this->order->shippingAddress->streetHtml())
            ->addKey('shipping_address_printout', $this->order->shippingAddress->fullPlainText())
            ->addKey('shipping_address_printout_html', $this->order->shippingAddress->fullHtml());

        return $this;
    }

    protected function addDiscountKeys(): static
    {
        $this->addKeyDefaultEmpty(
            'addtl_discount_display',
            "\r\nAddtl. Discount {$this->order->addtl_discount}",
            $this->order->addtl_discount > 0
        );

        return $this;
    }

    protected function addFeeKeys(): static
    {
        $this->addKeyDefaultEmpty(
            'addtl_fee_display',
            "\r\nAddtl. Fee: {$this->order->addtl_fee}",
            $this->order->addtl_fee > 0
        );

        $this->addKeyDefaultEmpty(
            'payment_method_fee_display',
            "\r\nPayment Method Fee: {$this->order->payment_method_fee}",
            $this->order->payment_method_fee > 0
        );

        return $this;
    }

    protected function addTotalKeys(): static
    {
        $this
            ->addKey('subtotal_display', $this->order->subTotal())
            ->addKey('tax_total_display', $this->order->taxTotal())
            ->addKey('shipping_total_display', $this->order->shippingTotal())
            ->addKey('total_display', $this->order->total());

        $this->addKeyDefaultEmpty(
            'discount_total_display',
            "\r\nDiscounts: -{$this->order->discountTotal()}",
            $this->order->discountTotal() > 0
        );

        return $this;
    }

    protected function addCommentKeys(): static
    {
        $this->addKeyDefaultEmpty(
            'comments_printout',
            "\r\nComments: {$this->order->comments}",
            $this->order->comments != ""
        );

        return $this;
    }

    protected function addCustomerKeys(): static
    {
        $this
            ->addKey('customer_or_billing_name', $this->getCustomerName())
            ->addKey('customer_first_name', $this->order->bill_first_name)
            ->addKey('customer_last_name', $this->order->bill_last_name);

        return $this;
    }

    protected function addRemainingKeys(): static
    {
        collect(OrderMessageKeys::cases())
            ->filter(
                fn (OrderMessageKeys $key) => !in_array($key->name, array_keys($this->keys))
            )
            ->each(
                fn (OrderMessageKeys $key) => $this->addKey($key->name, $this->order->{$key->value})
            );

        return $this;
    }

    protected function addKey(string $key, ?string $value): static
    {
        if ($value) {
            $this->keys[strtoupper($key)] = $value;
        }

        return $this;
    }

    protected function addKeyDefaultEmpty(string $key, string $value, bool $condition): static
    {
        $this->keys[strtoupper($key)] = "";

        if ($condition) {
            $this->keys[strtoupper($key)] = $value;
        }

        return $this;
    }

    protected function getCustomerName(): string
    {
        $name = $this->order->bill_first_name . " " . $this->order->bill_last_name;

        if ($this->order->account && $this->order->account->first_name != '') {
            $name = $this->order->account->first_name . ' ' . $this->order->account->last_name;
        }

        return $name;
    }
}
