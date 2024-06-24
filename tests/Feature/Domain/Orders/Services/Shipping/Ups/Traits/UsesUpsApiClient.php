<?php

namespace Tests\Feature\Domain\Orders\Services\Shipping\Ups\Traits;

use Database\Seeders\ShippingCarrierSeeder;
use Database\Seeders\ShippingGatewaySeeder;
use Database\Seeders\ShippingMethodSeeder;
use Domain\Distributors\Models\Shipping\DistributorShippingGateway;
use Domain\Distributors\Models\Shipping\DistributorShippingMethod;
use Domain\Distributors\Models\Shipping\DistributorUps;
use Domain\Orders\Enums\Shipping\ShippingGateways;
use Domain\Orders\Models\Shipping\ShippingMethod;
use Domain\Orders\Services\Shipping\Ups\Client;
use Domain\Orders\Services\Shipping\Ups\Dtos\Token;
use Domain\Orders\Services\Shipping\Ups\Enums\Modes;
use Domain\Orders\Services\Shipping\Ups\Enums\RateTypes;
use Illuminate\Support\Facades\Http;

trait UsesUpsApiClient
{
    protected Client $upsApiClient;
    protected ?DistributorUps $distributorService = null;

    public function initUpsClient(
        ?string $token = null,
        ?Modes  $mode = null
    ): static
    {
        $this->upsApiClient = new Client(
            config('services.ups.client_id'),
            config('services.ups.client_secret'),
            mode: $mode ?? Modes::Test,
            token: $token
        );

        return $this;
    }

    public function createDistributorService(?string $token = null): static
    {
        $this->seed(ShippingGatewaySeeder::class);

        $issuedAt = now()->timestamp;

        DistributorShippingGateway::firstOrFactory([
            'shipping_gateway_id' => ShippingGateways::Ups->value,
            'config' => [
                'test_mode' => true,
                'label_creation' => false,
                'rate_type' => RateTypes::Shop->value,
            ],
            'credentials' => [
                Modes::Test->value => [
                    'ups_account_number' => "dummy",
                    'auth_code' => <<<TEXT
Mk43VnZNR0UtVTJGc2RHVmtYMTg3eHJaMUxzYzg0ZnVRR3cyeGwrR2tEWkFVb0ZVSjY5UTlVeWNrYVcvU280RkpoYVhza2hxN3JNK3B1c1J6RXZxeWRkTGlteDFQdnc9PQ==
TEXT,
                    'token' => $token
                        ? Token::fromApi(
                            json_decode(<<<JSON
{
    "refresh_token_expires_in":"5183999",
    "refresh_token_status":"approved",
    "token_type":"Bearer",
    "issued_at":"{$issuedAt}",
    "client_id":"F1s7okBxknCwKZQj04F7kBwGxskOMFEz7cs1i27JUretTjQP",
    "access_token":"{$token}",
    "refresh_token":"d1RiQUFoRzJ6QndBSWZJVlRxYU91T2pyazhxamFFMUctVTJGc2RHVmtYMS9HclFncmthYi9ZOVE5NHU2NUQ2RFBxcXNpVVh5MEEvOHVuMCtrdGduVHMyU0RSM3dnMGpCZzM4STU5ckFRdG5TRk44VXVwRUs0ekE9PQ==",
    "refresh_token_issued_at":"1704392195613",
    "expires_in":"14399",
"status":"approved"
}
JSON
                                , true
                            )
                        )
                        : null
                ]
            ],
        ]);

        $this->distributorService = DistributorUps::first();

        return $this;
    }

    protected function prepShippingEntities()
    {
        $this->seed([
//            ShippingGatewaySeeder::class,
            ShippingCarrierSeeder::class,
            ShippingMethodSeeder::class
        ]);

        ShippingMethod::where('carrier_id', ShippingGateways::Ups->value)
            ->take(5)
            ->get()
            ->each(
                fn(ShippingMethod $shippingMethod) => DistributorShippingMethod::factory()
                    ->create([
                        'distributor_id' => $this->distributorService->distributor_id,
                        'shipping_method_id' => $shippingMethod->id,
                    ])
            );
    }

    protected function mockNewAccessTokenResponse(): void
    {
        Http::fakeSequence('*')
            ->push(<<<JSON
{"refresh_token_expires_in":"5183999","refresh_token_status":"approved","token_type":"Bearer","issued_at":"1704392195613","client_id":"F1s7okBxknCwKZQj04F7kBwGxskOMFEz7cs1i27JUretTjQP",
"access_token":"eyJraWQiOiI2NGM0YjYyMC0yZmFhLTQzNTYtYjA0MS1mM2EwZjM2Y2MxZmEiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzM4NCJ9.eyJzdWIiOiJmaXRsYXVuY2hAY29tY2FzdC5uZXQiLCJjbGllbnRpZCI6IkYxczdva0J4a25Dd0taUWowNEY3a0J3R3hza09NRkV6N2NzMWkyN0pVcmV0VGpRUCIsImlzcyI6Imh0dHBzOi8vYXBpcy51cHMuY29tIiwidXVpZCI6IjM1OTQyNTIyLTFBQjctMUIyNi1COERCLTNDNzMyMUU2NzhFNyIsInNpZCI6IjY0YzRiNjIwLTJmYWEtNDM1Ni1iMDQxLWYzYTBmMzZjYzFmYSIsImF1ZCI6IjIwMjMgZS1jb21tZXJjZSIsImF0IjoiM0xwR3FROGhvWHBlYjlYbERHZzZFcW94aWEzNSIsIm5iZiI6MTcwNDM5MjE5NSwiRGlzcGxheU5hbWUiOiIyMDIzIGUtY29tbWVyY2UiLCJleHAiOjE3MDQ0MDY1OTUsImlhdCI6MTcwNDM5MjE5NSwianRpIjoiODIxNjlhYWItN2QyZS00Nzc5LTlmYjUtOTVjMjFkYTU1MjI0In0.OHDPuBkOAdoZgQqwPq5VogX_-KH0r2hB0ueb9a7t20NOFBkMWV3gjqfpL1CJniV_GSPuKb04fWpjqFcu7hwSm-BDqzMmVg5PRZ5TlH4Jl4xcz40LvbY0hQZJQfhA6OFuTgoyXd31lPr0E-0njlIDKs6638fnq1YrMKAX_xgalnfuG-2rrRa4dolxLzxgxCIoQ_SbdBSswXz2zWqWb90n7vj7vcyiR6pFHWmP2jm6bBYltmQkkyp3KKvyDL2KiuTlgrxRk1uEcsMk4mOinYLdLE8JHf4Qi6Hm0uJhIjPgJdfGiOnwqoBfcDY4BmGhpfvGx884lncvowo0bJTOouAcCZlEo6tLI9RxsrJ2XOBpd8gHzUXb6C7mCuT5ZF_wX20TKXzCGlnmVtk5BF0_VDXJC4bksmmiDX59ZDr-1G6XsArZU8QtYhhR5_p3n6raiGK0EsYoTiOIKKH369-P9CxdHnh5dp3M7mh0AXL3aJ8ky36femlA1NUhlrEUlDBldiF0URiZC-qBrHGVxgo9fjs8Y-0168I_MiBRuj-PajF95dZsNF7xKWs5_4GfC0wprkNwK2ynXSGMqWbJAcjf591NREnViUsdcI7S0ep_Vlt36CUFDF0H4vyCS-wG3aN6B57FX4p5n8BJVnPnLStrElKvGfOqkcVK6KyV15lrsFdJIUI",
"refresh_token":"d1RiQUFoRzJ6QndBSWZJVlRxYU91T2pyazhxamFFMUctVTJGc2RHVmtYMS9HclFncmthYi9ZOVE5NHU2NUQ2RFBxcXNpVVh5MEEvOHVuMCtrdGduVHMyU0RSM3dnMGpCZzM4STU5ckFRdG5TRk44VXVwRUs0ekE9PQ==","refresh_token_issued_at":"1704392195613","expires_in":"14399","status":"approved"}
JSON
            );
    }

    protected function mockRefreshTokenResponse(): void
    {
        Http::fakeSequence('*')
            ->push(<<<JSON
{"refresh_token_expires_in":"5183999","refresh_token_status":"approved","token_type":"Bearer","issued_at":"1704392697899","client_id":"F1s7okBxknCwKZQj04F7kBwGxskOMFEz7cs1i27JUretTjQP","access_token":"eyJraWQiOiI2NGM0YjYyMC0yZmFhLTQzNTYtYjA0MS1mM2EwZjM2Y2MxZmEiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzM4NCJ9.eyJzdWIiOiJmaXRsYXVuY2hAY29tY2FzdC5uZXQiLCJjbGllbnRpZCI6IkYxczdva0J4a25Dd0taUWowNEY3a0J3R3hza09NRkV6N2NzMWkyN0pVcmV0VGpRUCIsImlzcyI6Imh0dHBzOi8vYXBpcy51cHMuY29tIiwidXVpZCI6IjM1OTQyNTIyLTFBQjctMUIyNi1COERCLTNDNzMyMUU2NzhFNyIsInNpZCI6IjY0YzRiNjIwLTJmYWEtNDM1Ni1iMDQxLWYzYTBmMzZjYzFmYSIsImF1ZCI6IjIwMjMgZS1jb21tZXJjZSIsImF0IjoicGpBbkQ0WlRUR2o3SXVLclBGak1ZSXRmMEFTRCIsIm5iZiI6MTcwNDM5MjY5NywiRGlzcGxheU5hbWUiOiIyMDIzIGUtY29tbWVyY2UiLCJleHAiOjE3MDQ0MDcwOTcsImlhdCI6MTcwNDM5MjY5NywianRpIjoiNzAzODQzMDUtMzdjMS00ZjFlLWI5N2UtZDI1NzViOGM3ZTU2In0.kUF8TYTRwTcmSZ9jfb1jNdP26Veq0HduRz6CwwWqeLJnL8gMGYZLdx_Sgs13hJMJ5WKJwlyrgyyfS0Fk9VdYeTvNdELzfuUQhFxuxZYtLscwQUyqF3cXiGQUBJzIXSAyTTGBnB_IzF-o3LHd3yFi7CYRWQaHVYQsOOEh-MNUcHKpDwMgWpRBMp4m4JkkH8qCCuZphrDO0hcuzIQPtLP2JdktEZPOUFsP2IYrTZvq-MYXsTrEp_6efQBTZft6jceSEbB8hhZ61mibnEE4deUYw9SIqRmWpECboCSCaqVDeTMx6vy36G6gL4UmXLKey6DTqfVLDo25VOc4rAX4ZjUWRe4Hj5UwVPjv0iarNA8cQ25NHkP-70Br_z2HRxeMk08RTQ88dp8_3-XCfxHJdQCi1PR0FndA10-VTEg1X3ZVe-qKvxtpKGljd9gz-9Dk4rPUGZk58ntWZVg3Nrv-Tlrr4NC0PhQ6sD8EcQnu5FvLphTu0xpoIjoUqF189iaW4zDfkyII50N_G_vjznrkjeLAzfUPRTTvohn1h7N5WtmYYwwhDfGAQygLEZ6UEwvp7h2TUw9G2BH_HwCpMbccZe5t_mr8uuvV3VCGWT1l6L2mdKQlj-c_E-LmFeIjDpBKvM7vAzZ-fPfrSNxU313zdifNJ9DyF6dHuyr7-hU59ofJkSY","refresh_token":"MEVLdG1lekFtbExPQnA5RTJISlNua3FTVW9pamhVUTctVTJGc2RHVmtYMS9HclFncmthYi9ZOVE5NHU2NUQ2RFBxcXNpVVh5MEEvOHVuMCtrdGduVHMyU0RSM3dnMGpCZzM4STU5ckFRdG5TRk44VXVwRUs0ekE9PQ==","refresh_token_issued_at":"1704392697899","expires_in":"14399","status":"approved"}
JSON
            );
    }

    protected function mockGetRatesResponse(): void
    {
        Http::fakeSequence('*')
            ->push(<<<JSON
{"RateResponse":{"Response":{"ResponseStatus":{"Code":"1", "Description":"Success"}, "Alert":[{"Code":"110971", "Description":"Your invoice may vary from the displayed reference rates"}, {"Code":"120900", "Description":"User Id and Shipper Number combination is not qualified to receive negotiated rates"}], "TransactionReference":""}, "RatedShipment":[{"Service":{"Code":"01", "Description":""}, "RatedShipmentAlert":[{"Code":"120900", "Description":"User Id and Shipper Number combination is not qualified to receive negotiated rates."}, {"Code":"110971", "Description":"Your invoice may vary from the displayed reference rates"}], "BillingWeight":{"UnitOfMeasurement":{"Code":"LBS", "Description":"Pounds"}, "Weight":"10.0"}, "TransportationCharges":{"CurrencyCode":"USD", "MonetaryValue":"66.89"}, "ServiceOptionsCharges":{"CurrencyCode":"USD", "MonetaryValue":"0.00"}, "TotalCharges":{"CurrencyCode":"USD", "MonetaryValue":"66.89"}, "GuaranteedDelivery":{"BusinessDaysInTransit":"1", "DeliveryByTime":"10:30 A.M."}, "RatedPackage":{"TransportationCharges":{"CurrencyCode":"USD", "MonetaryValue":"66.89"}, "ServiceOptionsCharges":{"CurrencyCode":"USD", "MonetaryValue":"0.00"}, "TotalCharges":{"CurrencyCode":"USD", "MonetaryValue":"66.89"}, "Weight":"10.0", "BillingWeight":{"UnitOfMeasurement":{"Code":"LBS", "Description":"Pounds"}, "Weight":"10.0"}}}, {"Service":{"Code":"02", "Description":""}, "RatedShipmentAlert":[{"Code":"120900", "Description":"User Id and Shipper Number combination is not qualified to receive negotiated rates."}, {"Code":"110971", "Description":"Your invoice may vary from the displayed reference rates"}], "BillingWeight":{"UnitOfMeasurement":{"Code":"LBS", "Description":"Pounds"}, "Weight":"10.0"}, "TransportationCharges":{"CurrencyCode":"USD", "MonetaryValue":"36.96"}, "ServiceOptionsCharges":{"CurrencyCode":"USD", "MonetaryValue":"0.00"}, "TotalCharges":{"CurrencyCode":"USD", "MonetaryValue":"36.96"}, "GuaranteedDelivery":{"BusinessDaysInTransit":"2"}, "RatedPackage":{"TransportationCharges":{"CurrencyCode":"USD", "MonetaryValue":"36.96"}, "ServiceOptionsCharges":{"CurrencyCode":"USD", "MonetaryValue":"0.00"}, "TotalCharges":{"CurrencyCode":"USD", "MonetaryValue":"36.96"}, "Weight":"10.0", "BillingWeight":{"UnitOfMeasurement":{"Code":"LBS", "Description":"Pounds"}, "Weight":"10.0"}}}, {"Service":{"Code":"03", "Description":""}, "RatedShipmentAlert":[{"Code":"120900", "Description":"User Id and Shipper Number combination is not qualified to receive negotiated rates."}, {"Code":"110971", "Description":"Your invoice may vary from the displayed reference rates"}], "BillingWeight":{"UnitOfMeasurement":{"Code":"LBS", "Description":"Pounds"}, "Weight":"10.0"}, "TransportationCharges":{"CurrencyCode":"USD", "MonetaryValue":"16.50"}, "ServiceOptionsCharges":{"CurrencyCode":"USD", "MonetaryValue":"0.00"}, "TotalCharges":{"CurrencyCode":"USD", "MonetaryValue":"16.50"}, "RatedPackage":{"TransportationCharges":{"CurrencyCode":"USD", "MonetaryValue":"16.50"}, "ServiceOptionsCharges":{"CurrencyCode":"USD", "MonetaryValue":"0.00"}, "TotalCharges":{"CurrencyCode":"USD", "MonetaryValue":"16.50"}, "Weight":"10.0", "BillingWeight":{"UnitOfMeasurement":{"Code":"LBS", "Description":"Pounds"}, "Weight":"10.0"}}}, {"Service":{"Code":"12", "Description":""}, "RatedShipmentAlert":[{"Code":"120900", "Description":"User Id and Shipper Number combination is not qualified to receive negotiated rates."}, {"Code":"110971", "Description":"Your invoice may vary from the displayed reference rates"}], "BillingWeight":{"UnitOfMeasurement":{"Code":"LBS", "Description":"Pounds"}, "Weight":"10.0"}, "TransportationCharges":{"CurrencyCode":"USD", "MonetaryValue":"29.49"}, "ServiceOptionsCharges":{"CurrencyCode":"USD", "MonetaryValue":"0.00"}, "TotalCharges":{"CurrencyCode":"USD", "MonetaryValue":"29.49"}, "GuaranteedDelivery":{"BusinessDaysInTransit":"3"}, "RatedPackage":{"TransportationCharges":{"CurrencyCode":"USD", "MonetaryValue":"29.49"}, "ServiceOptionsCharges":{"CurrencyCode":"USD", "MonetaryValue":"0.00"}, "TotalCharges":{"CurrencyCode":"USD", "MonetaryValue":"29.49"}, "Weight":"10.0", "BillingWeight":{"UnitOfMeasurement":{"Code":"LBS", "Description":"Pounds"}, "Weight":"10.0"}}}, {"Service":{"Code":"13", "Description":""}, "RatedShipmentAlert":[{"Code":"120900", "Description":"User Id and Shipper Number combination is not qualified to receive negotiated rates."}, {"Code":"110971", "Description":"Your invoice may vary from the displayed reference rates"}], "BillingWeight":{"UnitOfMeasurement":{"Code":"LBS", "Description":"Pounds"}, "Weight":"10.0"}, "TransportationCharges":{"CurrencyCode":"USD", "MonetaryValue":"64.31"}, "ServiceOptionsCharges":{"CurrencyCode":"USD", "MonetaryValue":"0.00"}, "TotalCharges":{"CurrencyCode":"USD", "MonetaryValue":"64.31"}, "GuaranteedDelivery":{"BusinessDaysInTransit":"1", "DeliveryByTime":"3:00 P.M."}, "RatedPackage":{"TransportationCharges":{"CurrencyCode":"USD", "MonetaryValue":"64.31"}, "ServiceOptionsCharges":{"CurrencyCode":"USD", "MonetaryValue":"0.00"}, "TotalCharges":{"CurrencyCode":"USD", "MonetaryValue":"64.31"}, "Weight":"10.0", "BillingWeight":{"UnitOfMeasurement":{"Code":"LBS", "Description":"Pounds"}, "Weight":"10.0"}}}, {"Service":{"Code":"14", "Description":""}, "RatedShipmentAlert":[{"Code":"120900", "Description":"User Id and Shipper Number combination is not qualified to receive negotiated rates."}, {"Code":"110971", "Description":"Your invoice may vary from the displayed reference rates"}], "BillingWeight":{"UnitOfMeasurement":{"Code":"LBS", "Description":"Pounds"}, "Weight":"10.0"}, "TransportationCharges":{"CurrencyCode":"USD", "MonetaryValue":"101.47"}, "ServiceOptionsCharges":{"CurrencyCode":"USD", "MonetaryValue":"0.00"}, "TotalCharges":{"CurrencyCode":"USD", "MonetaryValue":"101.47"}, "GuaranteedDelivery":{"BusinessDaysInTransit":"1", "DeliveryByTime":"8:30 A.M."}, "RatedPackage":{"TransportationCharges":{"CurrencyCode":"USD", "MonetaryValue":"101.47"}, "ServiceOptionsCharges":{"CurrencyCode":"USD", "MonetaryValue":"0.00"}, "TotalCharges":{"CurrencyCode":"USD", "MonetaryValue":"101.47"}, "Weight":"10.0", "BillingWeight":{"UnitOfMeasurement":{"Code":"LBS", "Description":"Pounds"}, "Weight":"10.0"}}}, {"Service":{"Code":"59", "Description":""}, "RatedShipmentAlert":[{"Code":"120900", "Description":"User Id and Shipper Number combination is not qualified to receive negotiated rates."}, {"Code":"110971", "Description":"Your invoice may vary from the displayed reference rates"}], "BillingWeight":{"UnitOfMeasurement":{"Code":"LBS", "Description":"Pounds"}, "Weight":"10.0"}, "TransportationCharges":{"CurrencyCode":"USD", "MonetaryValue":"42.08"}, "ServiceOptionsCharges":{"CurrencyCode":"USD", "MonetaryValue":"0.00"}, "TotalCharges":{"CurrencyCode":"USD", "MonetaryValue":"42.08"}, "GuaranteedDelivery":{"BusinessDaysInTransit":"2", "DeliveryByTime":"10:30 A.M."}, "RatedPackage":{"TransportationCharges":{"CurrencyCode":"USD", "MonetaryValue":"42.08"}, "ServiceOptionsCharges":{"CurrencyCode":"USD", "MonetaryValue":"0.00"}, "TotalCharges":{"CurrencyCode":"USD", "MonetaryValue":"42.08"}, "Weight":"10.0", "BillingWeight":{"UnitOfMeasurement":{"Code":"LBS", "Description":"Pounds"}, "Weight":"10.0"}}}]}}
JSON, 200);
    }
}
