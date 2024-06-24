<?php

namespace Tests\Feature\App\Api\Admin\Orders\Controllers;

use Domain\Accounts\Jobs\Membership\SendSiteMailable;
use Domain\Accounts\Models\Account;
use Domain\Orders\Models\Order\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class SendOrderEmailControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_send_order_email()
    {
        Mail::fake();
        Queue::fake();
        $account = Account::factory()->create();
        $order = Order::factory()->create(['account_id' => $account->id]);
        $this->postJson(route('admin.order.send-mail', $order))
            ->assertOk();

        Queue::assertPushed(
            SendSiteMailable::class,
            fn ($job) => $job->site->id === $order->site_id
                && $job->mailable->keyHandler->order->id === $order->id
                && $job->mailable->account->id === $order->account_id
        );
    }
}
