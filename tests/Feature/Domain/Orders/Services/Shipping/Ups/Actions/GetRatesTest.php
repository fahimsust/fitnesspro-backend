<?php


namespace Tests\Feature\Domain\Orders\Services\Shipping\Ups\Actions;


use Domain\Orders\Services\Shipping\Ups\Actions\GetRates;
use Domain\Orders\Services\Shipping\Ups\Client;
use Domain\Orders\Services\Shipping\Ups\Dtos\RateResponse\RateResponse;
use Domain\Orders\Services\Shipping\Ups\Enums\RateTypes;
use Illuminate\Support\Facades\Http;
use Support\Dtos\AddressDto;
use Tests\Feature\Domain\Orders\Services\Shipping\Ups\Traits\UsesUpsApiClient;

class GetRatesTest extends \Tests\TestCase
{
    use UsesUpsApiClient;

    /** @test */
    public function can_get()
    {
//        Http::allowStrayRequests();

        $this->mockGetRatesResponse();

        //{"refresh_token_expires_in":"5183999","refresh_token_status":"approved","token_type":"Bearer","issued_at":"1704403150060","client_id":"F1s7okBxknCwKZQj04F7kBwGxskOMFEz7cs1i27JUretTjQP","access_token":
        //"eyJraWQiOiI2NGM0YjYyMC0yZmFhLTQzNTYtYjA0MS1mM2EwZjM2Y2MxZmEiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzM4NCJ9.eyJzdWIiOiJmaXRsYXVuY2hAY29tY2FzdC5uZXQiLCJjbGllbnRpZCI6IkYxczdva0J4a25Dd0taUWowNEY3a0J3R3hza09NRkV6N2NzMWkyN0pVcmV0VGpRUCIsImlzcyI6Imh0dHBzOi8vYXBpcy51cHMuY29tIiwidXVpZCI6IjM1OTQyNTIyLTFBQjctMUIyNi1COERCLTNDNzMyMUU2NzhFNyIsInNpZCI6IjY0YzRiNjIwLTJmYWEtNDM1Ni1iMDQxLWYzYTBmMzZjYzFmYSIsImF1ZCI6IjIwMjMgZS1jb21tZXJjZSIsImF0IjoiUmVmNVEybmtlZ0RXaVFLdXI3dWZndlNHMUtHcSIsIm5iZiI6MTcwNDQwMzE1MCwiRGlzcGxheU5hbWUiOiIyMDIzIGUtY29tbWVyY2UiLCJleHAiOjE3MDQ0MTc1NTAsImlhdCI6MTcwNDQwMzE1MCwianRpIjoiMzI0OTgxMzAtYTc4NS00NDI3LTgyMDYtMDcyZmYwYzE2OGY5In0.nkB766zOs1JWmQpb6oEE89d_oOsZn8pYkfFnTx11VrTeySkRoowGWKNFa-ncGBoNNN-jSCxrwXWwlwL6r4-xPMl_lAnkljmkIvgo8OF8ZrGd0tTdoZ2FqOtIaBidNN8xHSHbnRgQh8N25rANH0Cg4BelrklRWg0Z2TG5Lle8B3pHPTSLbfGMYrL5_bAM573wt6XKGIFOzRK8pmla8Oy_vXc51_UlAtwFK8BDCP3Hwvru-tG_LsGi3PTx7RvCHlhKwzGDAdj11KKi0XE9nXtJ20LZzVbTTtv6KyLPoE9PC2w140LL4rSwytN_IjlDLz1v126GWY7eZqca43nE4VZ9f4-lkYeY31959RmZzVNr1V_cSFyO3y8Wjc7DhxDerd4eovtsj8o7aqYDZY2I9ZnNs1K6iMv_WCC4q2T_MAvnk-Szap0uW6qTWeSQlH4vHoSorPscxZtdIRFiwR9uwbgcU0jWYUEx03BXUB8UJtqhihyMiGDQFfQbVTDx-ylQQtBxPJzAfiEYfy4cc_v809g_zHrPfQC50yiGWtNfByQcdRV6kivdHRs_DfaHI7nKWQdIPCMUETtnHNJTiFliZHKx7xMHO4DwK7y88gkQwWfU2OeTryXmcUApi5EcP3cJbefC6kZjVCwjW--vRGr5XKfi-Uw3Ety6xQ7zTr2WM96BEgM","refresh_token":"ZkE3ZTM1ZmRVUHlYUUc1MUx1WjFybko2bVpOeDAxS0otVTJGc2RHVmtYMTh1QmFQQXJDamxjNnVKRWVYTDZ4NWFMTXgzSzZaZWdRbTdGK3dubTVOa0RXSFNsNUVHb0xONjBSQ0NaVUJob1dtRlhneXdVOWp3Y1E9PQ=="
        //,"refresh_token_issued_at":"1704403150060","expires_in":"14399","status":"approved"}

//        Client::$dumpResponse = true;
        $this->initUpsClient(
            token: "eyJraWQiOiI2NGM0YjYyMC0yZmFhLTQzNTYtYjA0MS1mM2EwZjM2Y2MxZmEiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzM4NCJ9.eyJzdWIiOiJmaXRsYXVuY2hAY29tY2FzdC5uZXQiLCJjbGllbnRpZCI6IkYxczdva0J4a25Dd0taUWowNEY3a0J3R3hza09NRkV6N2NzMWkyN0pVcmV0VGpRUCIsImlzcyI6Imh0dHBzOi8vYXBpcy51cHMuY29tIiwidXVpZCI6IjM1OTQyNTIyLTFBQjctMUIyNi1COERCLTNDNzMyMUU2NzhFNyIsInNpZCI6IjY0YzRiNjIwLTJmYWEtNDM1Ni1iMDQxLWYzYTBmMzZjYzFmYSIsImF1ZCI6IjIwMjMgZS1jb21tZXJjZSIsImF0IjoiUmVmNVEybmtlZ0RXaVFLdXI3dWZndlNHMUtHcSIsIm5iZiI6MTcwNDQwMzE1MCwiRGlzcGxheU5hbWUiOiIyMDIzIGUtY29tbWVyY2UiLCJleHAiOjE3MDQ0MTc1NTAsImlhdCI6MTcwNDQwMzE1MCwianRpIjoiMzI0OTgxMzAtYTc4NS00NDI3LTgyMDYtMDcyZmYwYzE2OGY5In0.nkB766zOs1JWmQpb6oEE89d_oOsZn8pYkfFnTx11VrTeySkRoowGWKNFa-ncGBoNNN-jSCxrwXWwlwL6r4-xPMl_lAnkljmkIvgo8OF8ZrGd0tTdoZ2FqOtIaBidNN8xHSHbnRgQh8N25rANH0Cg4BelrklRWg0Z2TG5Lle8B3pHPTSLbfGMYrL5_bAM573wt6XKGIFOzRK8pmla8Oy_vXc51_UlAtwFK8BDCP3Hwvru-tG_LsGi3PTx7RvCHlhKwzGDAdj11KKi0XE9nXtJ20LZzVbTTtv6KyLPoE9PC2w140LL4rSwytN_IjlDLz1v126GWY7eZqca43nE4VZ9f4-lkYeY31959RmZzVNr1V_cSFyO3y8Wjc7DhxDerd4eovtsj8o7aqYDZY2I9ZnNs1K6iMv_WCC4q2T_MAvnk-Szap0uW6qTWeSQlH4vHoSorPscxZtdIRFiwR9uwbgcU0jWYUEx03BXUB8UJtqhihyMiGDQFfQbVTDx-ylQQtBxPJzAfiEYfy4cc_v809g_zHrPfQC50yiGWtNfByQcdRV6kivdHRs_DfaHI7nKWQdIPCMUETtnHNJTiFliZHKx7xMHO4DwK7y88gkQwWfU2OeTryXmcUApi5EcP3cJbefC6kZjVCwjW--vRGr5XKfi-Uw3Ety6xQ7zTr2WM96BEgM"
        );

        $response = GetRates::now(
            client: $this->upsApiClient,
            rateType: RateTypes::Shop,
            upsAccountNumber: 'A267E1',
            shipFrom: AddressDto::from([
                'company' => '782 Media',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'address_1' => '1 Main St',
                'address_2' => '',
                'city' => 'San Jose',
                'countryAbbreviation' => "US",
                'stateAbbreviation' => "CA",
                'postal_code' => '95131',
                'phone' => '408-555-5555',
            ]),
            shipTo: AddressDto::from([
                'company' => '782 Media',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'address_1' => '1 Main St',
                'address_2' => '',
                'city' => 'San Jose',
                'countryAbbreviation' => "US",
                'stateAbbreviation' => "CA",
                'postal_code' => '95131',
                'phone' => '408-555-5555',
            ]),
            packageWeight: 10,
        );

        $this->assertInstanceOf(RateResponse::class, $response);
        $this->assertCount(7, $response->ratedShipments);
    }
}
