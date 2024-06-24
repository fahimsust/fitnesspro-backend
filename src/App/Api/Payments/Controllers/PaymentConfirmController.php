<?php

namespace App\Api\Payments\Controllers;

use App\Api\Payments\Requests\ConfirmPaymentRequest;
use Domain\Orders\Actions\Order\ConfirmPaymentForOrderTransaction;
use Domain\Orders\Actions\Order\Transaction\LoadOrderTransactionByIdFromCache;
use Support\Controllers\AbstractController;

class PaymentConfirmController extends AbstractController
{
    public function __invoke(ConfirmPaymentRequest $request)
    {
        return response()->json([
            'transaction' => ConfirmPaymentForOrderTransaction::run(
                transaction: LoadOrderTransactionByIdFromCache::now(
                    $request->order_transaction_id
                ),
                request: $request,
            )
                ->resultAsResource()
        ]);
    }
}
