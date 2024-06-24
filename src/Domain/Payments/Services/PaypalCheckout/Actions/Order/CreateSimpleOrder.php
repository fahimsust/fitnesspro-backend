<?php

namespace Domain\Payments\Services\PaypalCheckout\Actions\Order;

use Domain\Payments\Services\PaypalCheckout\Client;
use Domain\Payments\Services\PaypalCheckout\DataObjects\Order;
use Domain\Payments\Services\PaypalCheckout\Enums\Endpoints;
use Domain\Payments\Services\PaypalCheckout\Enums\PaymentIntents;
use Support\Contracts\AbstractAction;

class CreateSimpleOrder extends AbstractAction
{
    public function __construct(
        public Client         $client,
        public PaymentIntents $intent,
        public string         $orderNumber,
        public string         $currencyCode,
        public string         $amount,
        public string         $returnUrl,
        public string         $cancelUrl
    )
    {
    }

    public function execute(): Order
    {
        return Order::fromApi(
            $this->client
                ->post(
                    uri: Endpoints::Orders->value,
                    data: [
                        'intent' => $this->intent->value,
                        'purchase_units' => [
                            [
                                'reference_id' => $this->orderNumber,
                                'amount' => [
                                    'currency_code' => $this->currencyCode,
                                    'value' => $this->amount
                                ]
                            ]
                        ],
                        'payment_source' => [
                            'paypal' => [
                                'experience_context' => [
                                    'return_url' => $this->returnUrl,
                                    'cancel_url' => $this->cancelUrl,
                                    'locale_code' => 'en-US',
                                    'landing_page' => 'NO_PREFERENCE',
                                    'shipping_preference' => 'GET_FROM_FILE',
                                    'user_action' => 'PAY_NOW',
                                ]
                            ],
                        ]
                    ]
                )
                ->json()
        );
    }
}
