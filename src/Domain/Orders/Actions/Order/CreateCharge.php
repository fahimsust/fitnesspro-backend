<?php

namespace Domain\Orders\Actions\Order;

use App\Api\Admin\Orders\Requests\CreateOrderTransactionsRequest;
use Domain\Orders\Models\Order\Order;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Support\Contracts\AbstractAction;

class CreateCharge extends AbstractAction
{

    public function __construct(
        public Order                          $order,
        public CreateOrderTransactionsRequest $request
    )
    {
    }

    public function execute()
    {
        $insertData = [
            'amount' => $this->request->amount,
            'original_amount' => $this->request->amount,
            'notes' => $this->request->notes,
            'status' => 1,
        ];

        if ($this->request->charge_type == 1) {

            $gateWayAccount = PaymentAccount::find($this->request->gateway_account_id);
            $paymentMethod = PaymentMethod::whereGatewayId($gateWayAccount->gateway_id)->first();
            $_temp = [
                'cc_no' => substr($this->request->cc_number, -4),
                'cc_exp' => (string)$this->request->cc_exp_year . '-' . (string)$this->request->cc_exp_month . '-01',
                'payment_method_id' => $paymentMethod->id,
                'gateway_account_id' => $gateWayAccount->id,
                'capture_on_shipment' => 0,
                'transaction_no' => ''
            ];
            $insertData = array_merge($insertData, $_temp);
        } else {
            $insertData['transaction_no'] = $this->request->check_number;
            $insertData['payment_method_id'] = 2;
        }

        AddOrderActivity::now($this->order, "New charge " . $insertData['amount'] . "; Trans #" . $insertData['transaction_no']);

        return $this->order->transactions()->create($insertData);
    }
}
