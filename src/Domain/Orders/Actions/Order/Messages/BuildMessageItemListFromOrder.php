<?php

namespace Domain\Orders\Actions\Order\Messages;

use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Support\Contracts\AbstractAction;

class BuildMessageItemListFromOrder extends AbstractAction
{
    public string $plainText;
    public string $html;

    public function __construct(
        public Order $order
    ) {
        $this->order->loadMissing([
            'shipments.packages.items.optionValues',
            'shipments.packages.items.optionValues.optionValue',
            'shipments.packages.items.optionValues.optionValue.option',
            'shipments.packages.items.product',
            'shipments.packages.items.orderItemDiscounts',
            'shipments.packages.items.orderItemDiscounts.discount',
            'shipments.packages.items.customFields',
            'shipments.packages.items.customFields.section',
            'shipments.packages.items.customFields.field',
        ]);
    }

    public function execute(): static
    {
        $list = "";
        $list_html = $this->emailProductsHeader();

        foreach ($this->order->shipments as $shipment) {
            foreach ($shipment->packages as $package) {
                foreach ($package->items as $item) {
                    $this->appendProductTextAndHtml($item, $list, $list_html);
                }
            }
        }

        $this->order->shipments->each(
            fn (Shipment $shipment) => $shipment->packages->each(
                fn (OrderPackage $package) => $package->items->each(
                    function (OrderItem $item) use (&$list, &$list_html) {
                        $this->appendProductTextAndHtml($item, $list, $list_html);
                    }
                )
            )
        );

        $list_html .= $this->emailProductsFooter();

        $this->plainText = $list;
        $this->html = $list_html;

        return $this;
    }

    protected function appendProductTextAndHtml(OrderItem $item, string &$list, string &$list_html): void
    {
        $list .= $this->emailProductsItemText($item);
        $list_html .= $this->emailProductsItemHtml($item);
    }

    protected function emailProductsHeader(): string
    {
        return <<<HTML
<table cellpadding="3" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="font-weight:bold; border-bottom: 1px solid #eee;">
                Products</td>
            <td style="font-weight:bold;text-align:right; border-bottom: 1px solid #eee;">
                Qty</td>
            <td style="font-weight:bold;text-align:right; border-bottom: 1px solid #eee;">
                Price</td>
            <td style="font-weight:bold;text-align:right; border-bottom: 1px solid #eee;">
                Totals</td>
        </tr>
HTML;
    }

    protected function emailProductsFooter(): string
    {
        return <<<HTML
    </tbody>
</table>
HTML;
    }

    protected function emailProductsItemText(OrderItem $item): string
    {
        $list = "\r\n";

        if ($item->parent_product_id > 0) {
            $list .= "\t-";
        } else {
            $list .= "-----------------\r\n";
        }

        if ($item->label != "") {
            $list .= $item->label . "\r\n";
        }

        $list .= $item->title . ": " . $item->product_qty . " x " . $item->price . " = " . ($item->price * $item->product_qty) . "\r\n";

        if (count($item->optionValues) > 0) {
            $y = 0;
            foreach ($item->optionValues as $option) {
                if ($y != 0) $list .= "\r\n";
                $list .= $option->optionValue->option->display . ": " . $option->optionValue->display;
                $y++;
            }
        }
        if (count($item->customFields) > 0) {
            foreach ($item->customFields as $customField) {
                $list .= "\r\n" . $customField->field->display . ": " . $customField->field->value;
            }
        }

        if (count($item->orderItemDiscounts) > 0) {
            foreach ($item->orderItemDiscounts as $d) {
                $list .= $d->discount->display . ": Qty=" . $d->qty . " x " . $d->amount . " = -" . $d->getTotalDisplay($item->price) . "\r\n";
            }
        }
        return $list;
    }

    function emailProductsItemHtml(OrderItem $item): string
    {
        $list_html = "
        <tr>
            <td>";

        if ($item->parent_product_id > 0) {
            $list_html .= "&nbsp;&nbsp;<span style='font-size:11px;'>";
        }

        if ($item->label != "") {
            $list_html .= "<u>" . $item->label . '</u><br />&nbsp;&nbsp;';
        }

        $list_html .= $item->product->title;

        if (count($item->optionValues) > 0) {
            $list_html .= "
                            <br /><span style='font-size:11px;'>";
            $y = 0;
            foreach ($item->optionValues as $option) {
                if ($y != 0) $list_html .= "<br>";
                $list_html .= "&nbsp;&nbsp;" . $option->optionValue->option->display .
                    ": " . $option->optionValue->display;
                $y++;
            }
            $list_html .= "</span>";
        }
        if (count($item->customFields) > 0) {
            $list_html .= "<br /><span style='font-size:11px;'>";
            foreach ($item->customFields as $customField) {
                $list_html .= $customField->field->display . ": " . $customField->field->value;
            }
            $list_html .= "</span>";
        }

        $list_html .= "</td>
            <td style='text-align:right;'>" . $item->product_qty . "</td>
            <td style='text-align:right;'>" . $item->price . "</td>
            <td style='text-align:right;'>" . ($item->price * $item->product_qty) . "</td>
        </tr>";

        if (count($item->orderItemDiscounts) > 0) {
            foreach ($item->orderItemDiscounts as $orderItemDiscounts) {
                $list_html .= "
        <tr style='font-size:10px; color: red;'>
            <td style='padding-left:5px;'>" . $orderItemDiscounts->discount->display . "</td>
            <td style='text-align:right;'>" . $orderItemDiscounts->qty . "</td>
            <td style='text-align:right;'>" . $orderItemDiscounts->amount . "</td>
            <td style='text-align:right;'>-" . $orderItemDiscounts->getTotalDisplay($item->price, $item->product_qty) . "</td>
        </tr>";
            }
        }

        return $list_html;
    }
}
