<?php


namespace Tests\Feature\Domain\Orders\Actions\Cart\Order\Transaction;


use Domain\Orders\Actions\Order\Transaction\FindAlreadyStartedOrderTransaction;
use Domain\Orders\Actions\Order\Transaction\StartOrFindAlreadyStartedOrderTransaction;
use Domain\Orders\Enums\Order\OrderTransactionStatuses;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;

class StartOrFindExistingOrderTransactionTest extends \Tests\TestCase
{
    private float $amount;
    private Order $order;
    private PaymentAccount $paymentAccount;
    private PaymentMethod $paymentMethod;

    protected function setUp(): void
    {
        parent::setUp();

        $this->amount = 1.00;
        $this->order = Order::firstOrFactory();
        $this->paymentAccount = PaymentAccount::firstOrFactory();
        $this->paymentMethod = PaymentMethod::firstOrFactory();
    }

    /** @test */
    public function can_start_new()
    {
        $this->assertDatabaseCount(OrderTransaction::Table(), 0);

        StartOrFindAlreadyStartedOrderTransaction::now(
            order: $this->order,
            amount: $this->amount,
            paymentMethod: $this->paymentMethod,
            paymentAccount: $this->paymentAccount,
        );

        $this->assertDatabaseCount(OrderTransaction::Table(), 1);
    }


    /** @test */
    public function can_use_existing()
    {
        OrderTransaction::factory()
            ->for($this->order)
            ->create([
                'amount' => $this->amount,
                'payment_method_id' => $this->paymentMethod->id,
                'gateway_account_id' => $this->paymentAccount->id,
                'status' => OrderTransactionStatuses::Created,
            ]);

        $this->assertDatabaseCount(OrderTransaction::Table(), 1);

        StartOrFindAlreadyStartedOrderTransaction::now(
            order: $this->order,
            amount: $this->amount,
            paymentMethod: $this->paymentMethod,
            paymentAccount: $this->paymentAccount,
        );

        $this->assertDatabaseCount(OrderTransaction::Table(), 1);
    }

    /**
     * @test
     * @dataProvider mismatchedTransactions
     */
    public function can_ignore_mismatches(array $mismatchData)
    {
        //won't let me us factories in dataprovider, so i having to do it here
        if (isset($mismatchData['payment_method_id'])) {
            $mismatchData['payment_method_id'] = PaymentMethod::factory()->create()->id;
        }

        if(isset($mismatchData['gateway_account_id'])) {
            $mismatchData['gateway_account_id'] = PaymentAccount::factory()->create()->id;
        }

        OrderTransaction::factory()
            ->create(array_merge(
                [
                    'order_id' => $this->order->id,
                    'amount' => $this->amount,
                    'payment_method_id' => $this->paymentMethod->id,
                    'gateway_account_id' => $this->paymentAccount->id,
                    'status' => OrderTransactionStatuses::Created,
                    'created_at' => now(),
                ],
                $mismatchData
            ));

        $this->assertNull(
            FindAlreadyStartedOrderTransaction::now(
                order: $this->order,
                amount: $this->amount,
                paymentMethod: $this->paymentMethod,
                paymentAccount: $this->paymentAccount,
            )
        );
    }

    public static function mismatchedTransactions(): array
    {
        return [
            'amount' => [[
                'amount' => 2.00,
            ]],
            'payment_method' => [[
                'payment_method_id' => 1,
            ]],
            'account' => [[
                'gateway_account_id' => 1,
            ]],
            'status' => [[
                'status' => OrderTransactionStatuses::Authorized,
            ]],
            'created_at' => [[
                'created_at' => now()->subMinutes(11),
            ]],
        ];
    }
}
