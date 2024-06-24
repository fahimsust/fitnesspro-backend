<?php

namespace Tests\Feature\App\Api\Admin\Orders\Controllers;

use Domain\Accounts\Models\Account;
use Domain\Orders\Models\Checkout\Checkout;
use Domain\Orders\Models\Checkout\CheckoutItem;
use Domain\Orders\Models\Checkout\CheckoutPackage;
use Domain\Orders\Models\Checkout\CheckoutShipment;
use Domain\Orders\Models\Order\Order;
use Domain\Sites\Models\Site;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Tests\Feature\Traits\TestOrders;
use function route;

class AbandonedOrdersControllerTest extends ControllerTestCase
{
    use TestOrders;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_order_list()
    {
        Checkout::factory(10)->withAccount()->withOrder()->create();
        $response = $this->getJson(route('admin.abandoned-orders.index', ["per_page" => 30, "page" => 1]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'site',
                    'account',
                    'order'
                ]
            ]])
            ->assertJsonCount(10, 'data');
        $this->assertEquals(1, $response['current_page']);
    }
    /** @test */
    public function can_search_order_by_account()
    {
        $account = Account::factory()->create(
            [
                'first_name' => 'first_name',
            ]
        );
        $account2 = Account::factory()->create(
            [
                'last_name' => 'last_name',
            ]
        );
        $account3 = Account::factory()->create(
            [
                'email' => 'email@info.com'
            ]
        );
        Checkout::factory(10)->withOrder()->create(['account_id' => $account->id]);
        $this->getJson(route('admin.abandoned-orders.index', ['keyword' => 'first']))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'site',
                    'account',
                    'order'
                ]
            ]])
            ->assertJsonCount(10, 'data');

        Checkout::factory(12)->withOrder()->create(['account_id' => $account2->id]);
        $this->getJson(route('admin.abandoned-orders.index', ['keyword' => 'last']))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'site',
                    'account',
                    'order'
                ]
            ]])
            ->assertJsonCount(12, 'data');


        Checkout::factory(13)->withOrder()->create(['account_id' => $account3->id]);
        $this->getJson(route('admin.abandoned-orders.index', ['keyword' => 'email']))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'site',
                    'account',
                    'order'
                ]
            ]])
            ->assertJsonCount(13, 'data');
    }
    /** @test */
    public function can_search_order_by_order()
    {
        $order = Order::factory()->create(
            [
                'order_no' => 'order_no',
            ]
        );
        Checkout::factory(10)->withOrder()->create(['order_id'=>$order->id]);
        $this->getJson(route('admin.abandoned-orders.index', ['keyword' => 'order_no']))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'site',
                    'account',
                    'order'
                ]
            ]])
            ->assertJsonCount(10, 'data');
    }
    /** @test */
    public function can_search_order_by_site()
    {
        $site = Site::factory()->create(
            [
                'name' => 'site_name',
            ]
        );
        Checkout::factory(12)->withOrder()->create(['site_id'=>$site->id]);
        $this->getJson(route('admin.abandoned-orders.index', ['keyword' => 'site_name']))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'site',
                    'account',
                    'order'
                ]
            ]])
            ->assertJsonCount(12, 'data');
    }
    /** @test */
    public function can_get_order()
    {
        $checkout = Checkout::factory()->withAccount()->withOrder()->withAddresses()->create();
        $checkoutShipment = CheckoutShipment::factory()->create(['checkout_id' => $checkout->id]);
        $checkoutPackage = CheckoutPackage::factory()->create(['shipment_id' => $checkoutShipment->id]);
        CheckoutItem::factory()->create(['package_id' => $checkoutPackage->id]);
        $this->getJson(route('admin.abandoned-orders.show', [$checkout->id]))
            ->assertOk()
            ->assertJsonStructure([
                'id',
                'billing_address',
                'shipping_address',
                'items' => [
                    '*' => [
                        'cart_item' => [
                            'product'
                        ],
                    ]
                ],
                'shipments' => [
                    '*' => [
                        'id',
                    ]
                ]
            ]);
    }
}
