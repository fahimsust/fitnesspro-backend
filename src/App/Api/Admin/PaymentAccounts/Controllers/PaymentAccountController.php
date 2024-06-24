<?php

namespace App\Api\Admin\PaymentAccounts\Controllers;

use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\QueryBuilders\PaymentAccountQuery;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class PaymentAccountController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            PaymentAccount::query()
                ->when(
                    $request->filled('payment_method_id'),
                    fn (PaymentAccountQuery $query) => $query->forPaymentMethod($request)
                )->with('gateway')->orderBy('name')->get(),
            Response::HTTP_OK
        );
    }
}
