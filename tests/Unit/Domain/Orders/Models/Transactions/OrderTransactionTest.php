<?php

namespace Tests\Unit\Domain\Orders\Models\Transactions;

use Domain\Addresses\Models\Address;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Tests\TestCase;

class OrderTransactionTest extends TestCase
{


    private OrderTransaction $transaction;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transaction = OrderTransaction::factory()->create();
    }

    /** @test */
    public function can_get_billing_address()
    {
        $this->assertInstanceOf(Address::class, $this->transaction->billingAddress);
    }
}
