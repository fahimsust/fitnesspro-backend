<?php

namespace Domain\Orders\Actions\Order\Account;

use App\Api\Admin\Orders\Requests\AssignAccountRequest;
use Domain\Orders\Actions\Order\AddOrderActivity;
use Domain\Orders\Models\Order\Order;
use Support\Contracts\AbstractAction;

class AssignAccountToOrder extends AbstractAction
{

    public function __construct(
        public Order                $order,
        public AssignAccountRequest $request,
    )
    {
    }

    public function execute(): void
    {
        $this->order->update(['account_id' => $this->request->account_id]);

        AddOrderActivity::now(
            $this->order,
            "Assigned account " . $this->request->account_id
        );
    }
}
