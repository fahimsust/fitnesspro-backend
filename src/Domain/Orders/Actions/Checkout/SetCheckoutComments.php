<?php

namespace Domain\Orders\Actions\Checkout;

use Domain\Orders\Models\Checkout\Checkout;
use Support\Contracts\AbstractAction;

class SetCheckoutComments extends AbstractAction
{
    public function __construct(
        public Checkout $checkout,
        public string   $comments,
    )
    {
    }

    public function execute(): Checkout
    {
        $this->checkout->update([
            'comments' => $this->comments,
        ]);

        return $this->checkout;
    }
}
