<?php

namespace App\Api\Orders\Resources\Order;

use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderTransactionResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var OrderTransaction $transaction */
        $transaction = $this->resource;

        return [
            'id' => $transaction->id,
            'order_id' => $transaction->order_id,
            'payment_method_id' => $transaction->payment_method_id,
            'payment_account_id' => $transaction->gateway_account_id,
            'billing_address_id' => $transaction->billing_address_id,
            'amount' => $transaction->amount,
            'original_amount' => $transaction->original_amount,
            'currency' => $transaction->currency,
            'status' => [
                'id' => $transaction->status,
                'name' => $transaction->status->label(),
            ],
            'created_at' => $transaction->created_at,
            'updated_at' => $transaction->updated_at,
            'voided_at' => $transaction->voided_at,
        ];
    }
}
