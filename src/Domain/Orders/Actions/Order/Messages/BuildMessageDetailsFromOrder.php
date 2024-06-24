<?php

namespace Domain\Orders\Actions\Order\Messages;

use Domain\Orders\Models\Order\Order;
use Support\Contracts\AbstractAction;

class BuildMessageDetailsFromOrder extends AbstractAction
{
    public string $plainText;
    public string $html;

    public function __construct(
        public Order $order,
        public ?BuildMessageItemListFromOrder $itemListBuilder = null
    ) {
    }

    public function execute(): static
    {
        $details = $this->buildPlainTextDetails();
        $details_html = $this->buildHtmlDetails();

        $this->plainText = $details;
        $this->html = $details_html;

        return $this;
    }

    protected function buildPlainTextDetails(): string
    {
        $details = $this->itemListBuilder->plainText;

        $details .= "\r\n\r\nSubTotal: {$this->order->subTotal()}";

        if ($this->order->addtl_discount > 0) {
            $details .= "\r\nAddtl. Discount: -{$this->order->addtl_discount}";
        }

        if ($this->order->addtl_fee > 0) {
            $details .= "\r\nAddtl. Fee: {$this->order->addtl_fee}";
        }

        if ($this->order->payment_method_fee > 0) {
            $details .= "\r\nPayment Method Fee: {$this->order->payment_method_fee}";
        }

        if ($this->order->discountTotal() > 0) {
            $details .= "\r\nDiscounts: -{$this->order->discountTotal()}";
        }

        $details .= "\r\n\r\nTax: {$this->order->taxTotal()}"
            . "\r\nShipping: {$this->order->shippingTotal()}"
            . "\r\nTOTAL: {$this->order->total()}";

        return $details;
    }

    protected function buildHtmlDetails(): string
    {
        $details_html = $this->itemListBuilder->html;

        $details_html .= <<<HTML
<table cellpadding="3" cellspacing="0" width="100%" style="border-top: 1px solid #eee;">
    <tr>
        <td style="width:80%; text-align:right;">SubTotal:</td>
        <td style="text-align:right;">{$this->order->subTotal()}</td>
    </tr>
HTML;

        $details_html .= $this->buildHtmlRow('Addtl. Discount', $this->order->addtl_discount);
        $details_html .= $this->buildHtmlRow('Addtl. Fee', $this->order->addtl_fee);
        $details_html .= $this->buildHtmlRow('Payment Method Fee', $this->order->payment_method_fee);
        $details_html .= $this->buildHtmlRow('Discounts', $this->order->discountTotal());

        $details_html .= <<<HTML
    <tr>
        <td style="width:80%; text-align:right;">Tax:</td>
        <td style="text-align:right;">{$this->order->taxTotal()}</td>
    </tr>
    <tr>
        <td style="width:80%; text-align:right;">Shipping:</td>
        <td style="text-align:right;">{$this->order->shippingTotal()}</td>
    </tr>
    <tr style="font-weight:bold;">
        <td style="width:80%; text-align:right;">Total:</td>
        <td style="text-align:right;">{$this->order->total()}</td>
    </tr>
</table>
HTML;

        return $details_html;
    }

    protected function buildHtmlRow(string $label, ?float $value): string
    {
        if ($value && $value > 0) {
            return <<<HTML
    <tr>
        <td style="width:80%; text-align:right;">$label:</td>
        <td style="text-align:right;">$value</td>
    </tr>
HTML;
        }

        return '';
    }
}
