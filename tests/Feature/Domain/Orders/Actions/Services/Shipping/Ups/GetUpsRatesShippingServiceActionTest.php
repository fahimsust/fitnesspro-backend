<?php


namespace Tests\Feature\Domain\Orders\Actions\Services\Shipping\Ups;


use Database\Seeders\ShippingCarrierSeeder;
use Database\Seeders\ShippingMethodSeeder;
use Domain\Distributors\Models\Shipping\DistributorShippingMethod;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Domain\Orders\Actions\Checkout\Shipment\BuildShipmentDtosFromCart;
use Domain\Orders\Actions\Services\Shipping\Ups\GetUpsRatesShippingServiceAction;
use Domain\Orders\Actions\Shipping\GetAvailableShippingMethodsForDistributors;
use Domain\Orders\Dtos\Shipping\ShippingRateDto;
use Domain\Orders\Enums\Shipping\ShippingGateways;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Shipping\ShippingMethod;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Support\Dtos\AddressDto;
use Tests\Feature\Domain\Orders\Services\Shipping\Ups\Traits\UsesUpsApiClient;
use Tests\Feature\Traits\TestCarts;

class GetUpsRatesShippingServiceActionTest extends \Tests\TestCase
{
    use UsesUpsApiClient,
        TestCarts;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createDistributorService("dummy-token");
    }

    /** @test */
    public function can()
    {
        $this->mockGetRatesResponse();

        $rates = $this->prepAndPerform();

        $this->assertCount(3, $rates);
        $this->assertInstanceOf(ShippingRateDto::class, $rates->first());
    }

    /** @test */
    public function can_handle_failure()
    {
        Http::fakeSequence('*')
            ->push(null, 400);

        $this->expectException(RequestException::class);

        $this->prepAndPerform();
    }

    private function prepAndPerform()
    {
        $this->prepShippingEntities();

        $this->createCartItems();

        $shipmentDto = BuildShipmentDtosFromCart::now(
            Cart::first(),
        )->first();

        $availableMethods = GetAvailableShippingMethodsForDistributors::now(
            distributorIds: $this->distributorService->distributor_id,
            address: $toAddress = AddressDto::from([
                'company' => '782 Media',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'address_1' => '1 Main St',
                'address_2' => '',
                'city' => 'San Jose',
                'country_id' => Country::firstOrFactory()->id,
                'state_id' => StateProvince::firstOrFactory()->id,
                'postal_code' => '95131',
                'phone' => '408-555-5555',
            ]),
        );

        return GetUpsRatesShippingServiceAction::now(
            $this->distributorService,
            $toAddress,
            $shipmentDto,
            $availableMethods
        );
    }
}
