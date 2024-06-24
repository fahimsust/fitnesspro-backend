<?php

namespace App\Api\Admin\Orders\Controllers;

use App\Api\Admin\Orders\Requests\AssignAccountRequest;
use Domain\Accounts\Models\Account;
use Domain\Orders\Actions\Order\Account\AssignAccountToOrder;
use Domain\Orders\Actions\Order\Account\UnassignAccountFromOrder;
use Domain\Orders\Models\Order\Order;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OrderAccountController extends AbstractController
{
    public function update(Order $order, AssignAccountRequest $request)
    {
        return response(
            AssignAccountToOrder::now($order, $request),
            Response::HTTP_CREATED
        );
    }

    public function destroy(Order $order, Account $account)
    {
        return response(
            UnassignAccountFromOrder::now($order, $account),
            Response::HTTP_OK
        );
    }
}
