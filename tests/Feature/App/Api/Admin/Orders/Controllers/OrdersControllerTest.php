<?php

namespace Tests\Feature\App\Api\Admin\Orders\Controllers;

use Carbon\Carbon;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderActivity;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Tests\Feature\Traits\TestOrders;
use function route;

class OrdersControllerTest extends ControllerTestCase
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
        $this->createOrders(true);
        $response = $this->getJson(route('admin.orders.index', ["per_page" => 30, "page" => 1]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'order_no',
                    'notes',
                    'shipments' => [
                        '*' => [
                            'id',
                            'is_downloads',
                            'items' => [
                                '*' => [
                                    'product'
                                ]
                            ],
                            'distributor'
                        ]
                    ]
                ]
            ]])
            ->assertJsonCount(10, 'data');
        $this->assertEquals(1, $response['current_page']);
    }

    /** @test */
    public function can_search_order_by_account_first_name()
    {
        $this->createOrders();
        $this->getJson(route('admin.orders.index', ['keyword' => $this->firstName]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'order_no',
                ]
            ]])
            ->assertJsonCount(1, 'data');
    }
    /** @test */
    public function can_search_order_by_billing_first_name()
    {
        $this->createOrders();
        $this->getJson(route('admin.orders.index', ['keyword' => $this->billingFirstName]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'order_no'
                ]
            ]])
            ->assertJsonCount(1, 'data');
    }
    /** @test */
    public function can_search_order_by_shipping_first_name()
    {
        $this->createOrders();
        $this->getJson(route('admin.orders.index', ['keyword' => $this->shippingFirstName]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'order_no'
                ]
            ]])
            ->assertJsonCount(1, 'data');
    }
    /** @test */
    public function can_search_order_by_phone()
    {
        $this->createOrders();
        $this->getJson(route('admin.orders.index', ['keyword' => $this->orderPhone]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'order_no'
                ]
            ]])
            ->assertJsonCount(1, 'data');
    }
    /** @test */
    public function can_search_order_by_email()
    {
        $this->createOrders();
        $this->getJson(route('admin.orders.index', ['keyword' => $this->orderEmail]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'order_no'
                ]
            ]])
            ->assertJsonCount(1, 'data');
    }
    /** @test */
    public function can_search_order_by_start_end_date()
    {
        $this->createOrders();
        $start_date = Carbon::now()->subDays(12)->toDateString();
        $end_date = Carbon::now()->subDays(8)->toDateString();
        $this->getJson(route('admin.orders.index', ['start_date' => $start_date, 'end_date' => $end_date]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'order_no'
                ]
            ]])
            ->assertJsonCount(1, 'data');
    }
    /** @test */
    public function can_search_order_by_trip_start_end_date()
    {
        $this->createOrders(true);
        $start_date = Carbon::now()->subDays(12)->toDateString();
        $end_date = Carbon::now()->subDays(8)->toDateString();
        $this->getJson(route('admin.orders.index', ['start_date_travel' => $start_date, 'end_date_travel' => $end_date]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'order_no'
                ]
            ]])
            ->assertJsonCount(10, 'data');
    }
    /** @test */
    public function can_search_order_by_order_no()
    {
        $this->createOrders();
        $this->getJson(route('admin.orders.index', ['order_no' => $this->orderNo]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'order_no'
                ]
            ]])
            ->assertJsonCount(1, 'data');
    }
    /** @test */
    public function can_search_order_by_country()
    {
        $this->createOrders();
        $this->getJson(route('admin.orders.index', ['country_id' => $this->countryId]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'order_no'
                ]
            ]])
            ->assertJsonCount(1, 'data');
    }
    /** @test */
    public function can_search_order_by_state()
    {
        $this->createOrders();
        $this->getJson(route('admin.orders.index', ['state_id' => $this->stateId]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'order_no'
                ]
            ]])
            ->assertJsonCount(1, 'data');
    }
    /** @test */
    public function can_search_order_by_payment_method()
    {
        $this->createOrders();
        $this->getJson(route('admin.orders.index', ['payment_method_id' => $this->paymentMethodId]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'order_no'
                ]
            ]])
            ->assertJsonCount(1, 'data');
    }
    /** @test */
    public function can_search_order_by_status()
    {
        $this->createOrders(true);
        $this->getJson(route('admin.orders.index', ['status_id' => $this->statusId]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'order_no',
                    'notes',
                    'shipments' => [
                        '*' => [
                            'id',
                            'is_downloads',
                            'items' => [
                                '*' => [
                                    'product'
                                ]
                            ],
                            'distributor'
                        ]
                    ]
                ]
            ]])
            ->assertJsonCount(5, 'data');
    }
    /** @test */
    public function can_search_order_by_shipment()
    {
        $this->createOrders(true);
        $this->getJson(route('admin.orders.index', ['shipping_method_id' => $this->shippingMethodId]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'order_no',
                    'notes',
                    'shipments' => [
                        '*' => [
                            'id',
                            'is_downloads',
                            'items' => [
                                '*' => [
                                    'product'
                                ]
                            ],
                            'distributor'
                        ]
                    ]
                ]
            ]])
            ->assertJsonCount(6, 'data');
    }
     /** @test */
     public function can_search_order_by_product_type()
     {
         $this->createOrders(true);
         $this->getJson(route('admin.orders.index', ['product_type_id' => $this->productTypeId]))
             ->assertOk()
             ->assertJsonStructure(['data' => [
                 '*' => [
                     'id',
                     'order_no',
                     'notes',
                     'shipments' => [
                         '*' => [
                             'id',
                             'is_downloads',
                             'items' => [
                                 '*' => [
                                     'product'
                                 ]
                             ],
                             'distributor'
                         ]
                     ]
                 ]
             ]])
             ->assertJsonCount(6, 'data');
     }
    /** @test */
    public function can_search_order_by_distributor()
    {
        $this->createOrders(true);
        $this->getJson(route('admin.orders.index', ['distributor_id' => $this->distributorId]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'order_no',
                    'notes',
                    'shipments' => [
                        '*' => [
                            'id',
                            'is_downloads',
                            'items' => [
                                '*' => [
                                    'product'
                                ]
                            ],
                            'distributor'
                        ]
                    ]
                ]
            ]])
            ->assertJsonCount(7, 'data');
    }
    /** @test */
    public function can_get_order()
    {
        $this->createOrders();
        $order = Order::first();
        $this->getJson(route('admin.orders.show', [$order->id]))
            ->assertOk()
            ->assertJsonStructure([
                'id',
                'order_no',
                'notes',
                'shipments' => [
                    '*' => [
                        'id',
                        'is_downloads',
                        'packages' => [
                            '*' => [
                                'items' => [
                                    '*' => [
                                        'product'
                                    ]
                                ],
                            ]
                        ],
                        'distributor'
                    ]
                ]
            ]);
    }
    /** @test */
    public function can_update_order_shipment()
    {
        $order = Order::factory()->create();
        $this->putJson(route('admin.orders.update', [$order]), ['addtl_fee' => 10.10])
            ->assertCreated();

        $this->assertEquals(10.10, $order->refresh()->addtl_fee);

        $this->putJson(route('admin.orders.update', [$order]), ['addtl_discount' => 10.10])
            ->assertCreated();
        $this->assertEquals(10.10, $order->refresh()->addtl_discount);

        $this->assertDatabaseCount(OrderActivity::Table(), 2);
    }
}
