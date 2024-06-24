<?php

namespace Tests\Feature\App\Api\Payments\Controllers;

use Domain\Orders\Enums\Order\OrderTransactionStatuses;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Enums\PaymentMethodActions;
use Domain\Payments\Models\PaymentMethod;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PaymentCancelControllerTest extends TestCase
{
    /** @test */
    public function can()
    {
        $transaction = OrderTransaction::factory()
            ->create([
                'payment_method_id' => PaymentMethod::factory()
                    ->create([
                        'id' => PaymentMethodActions::PaypalProExpress->value
                    ]),
                'status' => OrderTransactionStatuses::Pending
            ]);

        $result = $this->postJson(route('api.payment.cancel', [
            'order_transaction_id' => $transaction->id,
        ]))
            ->assertStatus(Response::HTTP_ACCEPTED)
            ->assertJsonStructure(['message']);

        $this->assertSoftDeleted($transaction->fresh());
    }

    /** @test */
    public function can_fail_if_not_found()
    {
        $this->postJson(route('api.payment.cancel', [
            'order_transaction_id' => 1,
        ]))
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure([
                'message',
            ]);
    }

    /** @test */
    public function requires_transaction_id()
    {
        $this->postJson(route('api.payment.cancel', [
            'order_transaction_id' => 0,
        ]))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrorFor('order_transaction_id')
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
    }
}
