<?php

namespace Domain\Payments\Actions;

use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Enums\FrontendPaymentActions;
use Support\Contracts\AbstractAction;

class CreatePaymentUrlWithTransactionForFrontend extends AbstractAction
{
    public function __construct(
        public OrderTransaction       $transaction,
        public FrontendPaymentActions $action,
    )
    {
    }

    public function execute(): string
    {
        return config('app.frontend.url')
            . "/payment"
            . "/{$this->transaction->id}"
            . "/{$this->action->value}";
    }
}
