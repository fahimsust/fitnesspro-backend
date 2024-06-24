<?php

namespace Tests\Feature\App\Api\Orders\Controllers\Checkout;

use Domain\Orders\Collections\CalculatedShippingRatesCollection;
use Domain\Orders\Dtos\Shipping\ShippingRateDto;
use Domain\Orders\Models\Checkout\CheckoutShipment;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\Feature\Traits\TestCheckouts;
use Tests\TestCase;
use function route;

class ShipmentsControllerTest extends TestCase
{
    use TestCheckouts;

    protected function setUp(): void
    {
        parent::setUp();

        $this->prepToRateShipments();
    }

    /** @test */
    public function can_rate()
    {
        $this->mockGetRatesResponse();

        $response = $this->getJson(
            route('checkout.shipments.rate', $this->checkout->uuid)
        )
            ->assertOk()
            ->assertJsonStructure([
                'shipments' => [
                    '*' => [
                        'id',
                        'weight',
                        'distributor_id',
                        'packages' => [
                            '*' => [
                                'weight',
                                'items' => [
                                    '*' => [
                                        'price_reg',
                                        'price_sale',
                                        'onsale',
                                        'product_id',
                                        'title',
                                        'availability',
                                        'combined_qty',
                                        'distributor_qty',
                                        'package_qty',
                                    ]
                                ]
                            ]
                        ],
                        'rates' => [
                            '*' => [
                                'id',
                                'reference_name',
                                'price',
                                'display',
                                'description',
                                'call_for_estimate',
                            ]
                        ]
                    ]
                ]
            ]);

        $this->assertCount(1, $response->json('shipments'));
        $this->assertCount(1, $response->json('shipments.0.packages'));
        $this->assertCount(3, $response->json('shipments.0.rates'));
//        dd($response->getJson());
    }

    /** @test */
    public function can_save_methods()
    {
//        $this->withoutExceptionHandling();
        $this->createCheckoutItems();

        $json = json_decode(<<<JSON
{"shipments":[{"id":267,"weight":98,"distributor_id":538,"packages":[{"weight":98,"items":[{"price_reg":225.94,"price_sale":190.03,"onsale":false,"product_id":7694,"title":"enim est est ut incidunt","availability":{"id":1161,"name":"rerum","display":"dolorum","qty_min":null,"qty_max":null,"auto_adjust":false},"combined_qty":1,"distributor_qty":4,"package_qty":3},{"price_reg":244.67,"price_sale":188.4,"onsale":false,"product_id":7695,"title":"non at et est porro","availability":{"id":1161,"name":"rerum","display":"dolorum","qty_min":null,"qty_max":null,"auto_adjust":false},"combined_qty":1,"distributor_qty":30,"package_qty":1},{"price_reg":204.9,"price_sale":172.22,"onsale":false,"product_id":7694,"title":"enim est est ut incidunt","availability":{"id":1161,"name":"rerum","display":"dolorum","qty_min":null,"qty_max":null,"auto_adjust":false},"combined_qty":1,"distributor_qty":4,"package_qty":3}]}],"rates":[
{"id":30,"reference_name":"01","price":112.1,"display":"ut","description":null,"call_for_estimate":false},{"id":31,"reference_name":"02","price":60.31,"display":"assumenda","description":null,"call_for_estimate":false},{"id":32,"reference_name":"03","price":25.41,"display":"in","description":null,"call_for_estimate":false}]}]}
JSON,
            true);

        $this->shipments
            ->each(
                fn(CheckoutShipment $shipment) => $shipment->update([
                    'shipping_method_id' => null,
                    'latest_rates' => new CalculatedShippingRatesCollection(
                        collect($json['shipments'][0]['rates'])
                            ->map(
                                fn(array $rate) => ShippingRateDto::fromArray(
                                    data: $rate,
                                )
                            )
                    ),
                    'rated_at' => now()
                ])
            );

        $response = $this->postJson(
            route(
                'checkout.shipments.methods.save',
                $this->checkout->uuid
            ),
            [
                'shipments' => $this->shipments
                    ->map(
                        fn(CheckoutShipment $shipment) => [
                            'id' => $shipment->id,
                            'method_id' => $shipment->rates()->random()->id
                        ]
                    )->toArray()
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                'shipments' => [
                    '*' => [
                        'id',
                        'shipping_method' => [
                            'id',
                            'label',
                            'cost'
                        ]
                    ]
                ]
            ]);

//        dd($response->json());
    }

    /** @test */
    public function can_update_method()
    {
        $this->withoutExceptionHandling();
        $this->createCheckoutItems();

        $json = json_decode(<<<JSON
{"shipments":[{"id":267,"weight":98,"distributor_id":538,"packages":[{"weight":98,"items":[{"price_reg":225.94,"price_sale":190.03,"onsale":false,"product_id":7694,"title":"enim est est ut incidunt","availability":{"id":1161,"name":"rerum","display":"dolorum","qty_min":null,"qty_max":null,"auto_adjust":false},"combined_qty":1,"distributor_qty":4,"package_qty":3},{"price_reg":244.67,"price_sale":188.4,"onsale":false,"product_id":7695,"title":"non at et est porro","availability":{"id":1161,"name":"rerum","display":"dolorum","qty_min":null,"qty_max":null,"auto_adjust":false},"combined_qty":1,"distributor_qty":30,"package_qty":1},{"price_reg":204.9,"price_sale":172.22,"onsale":false,"product_id":7694,"title":"enim est est ut incidunt","availability":{"id":1161,"name":"rerum","display":"dolorum","qty_min":null,"qty_max":null,"auto_adjust":false},"combined_qty":1,"distributor_qty":4,"package_qty":3}]}],"rates":[
{"id":30,"reference_name":"01","price":112.1,"display":"ut","description":null,"call_for_estimate":false},{"id":31,"reference_name":"02","price":60.31,"display":"assumenda","description":null,"call_for_estimate":false},{"id":32,"reference_name":"03","price":25.41,"display":"in","description":null,"call_for_estimate":false}]}]}
JSON,
            true);

        /** @var CheckoutShipment $shipment */
        $shipment = $this->shipments->first();
        $shipment->update([
            'shipping_method_id' => null,
            'latest_rates' => new CalculatedShippingRatesCollection(
                collect($json['shipments'][0]['rates'])
                    ->map(
                        fn(array $rate) => ShippingRateDto::fromArray(
                            data: $rate,
                        )
                    )
            ),
            'rated_at' => now()
        ]);

        $selectedMethodId = $shipment->rates()->filter(
            fn(ShippingRateDto $rate) => $rate->id !== $shipment->shipping_method_id
        )->random()->id;

        $response = $this->putJson(
            route(
                'checkout.shipments.shipment.method.update',
                [
                    $this->checkout->uuid,
                    $shipment->id
                ]
            ),
            [
                'method_id' => $selectedMethodId
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                'shipment' => [
                    'id',
                    'shipping_method' => [
                        'id',
                        'label',
                        'cost'
                    ]
                ]
            ]);

        $this->assertEquals($selectedMethodId, $response->json('shipment.shipping_method.id'));

//        dd($response->json());
    }

    /** @test */
    public function fails_if_cart_missing()
    {
        $response = $this->getJson(
            route('checkout.shipments.rate', "dummy-uuid")
        )
            ->assertNotFound()
            ->assertJsonStructure([
                'message',
                'exception'
            ]);

        $this->assertEquals(NotFoundHttpException::class, $response->json('exception'));
//        dd($response->json());
    }
}
