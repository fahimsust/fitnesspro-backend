<?php

namespace Support\Traits;

trait RequestCanReturnOrderResource
{
    public function rules()
    {
        $rules = [
            'include_account' => ['sometimes', 'boolean'],
            'include_affiliate' => ['sometimes', 'boolean'],
            'include_billing_address' => ['sometimes', 'boolean'],
            'include_shipping_address' => ['sometimes', 'boolean'],
            'include_payment_method' => ['sometimes', 'boolean'],
            'include_items' => ['sometimes', 'boolean'],
            'include_discounts' => ['sometimes', 'boolean'],
            'include_notes' => ['sometimes', 'boolean'],
            'include_site' => ['sometimes', 'boolean'],
            'include_transactions' => ['sometimes', 'boolean'],
            'include_shipments' => ['sometimes', 'boolean'],
            'discount_relations' => ['sometimes', 'array'],
            'item_relations' => ['sometimes', 'array'],
            'shipment_relations' => ['sometimes', 'array'],
            'notes_page' => ['sometimes', 'integer', 'gte:1'],
        ];

        if(!method_exists(parent::class, 'rules')) {
            return $rules;
        }

        return parent::rules()
            + $rules;
    }
}
