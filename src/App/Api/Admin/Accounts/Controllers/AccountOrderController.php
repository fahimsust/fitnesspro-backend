<?php

namespace App\Api\Admin\Accounts\Controllers;


use Domain\Orders\Models\Order\Order;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AccountOrderController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            Order::orderBy('id', 'DESC')
                ->limit(100)
                ->where('account_id', $request->account_id)->get(),
            Response::HTTP_OK
        );
    }
}
