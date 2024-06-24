<?php

namespace App\Api\Payments\Controllers;

use App\Api\Payments\Requests\CancelPaymentRequest;
use Domain\Orders\Actions\Order\CancelPaymentForOrderTransaction;
use Domain\Orders\Actions\Order\Transaction\LoadOrderTransactionByIdFromCache;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PaymentCancelController extends AbstractController
{
    public function __invoke(CancelPaymentRequest $request)
    {
        return response()->json(
            data: CancelPaymentForOrderTransaction::run(
                transaction: LoadOrderTransactionByIdFromCache::now(
                    $request->order_transaction_id
                ),
                request: $request,
            ),
            status: Response::HTTP_ACCEPTED
        );
    }
}
