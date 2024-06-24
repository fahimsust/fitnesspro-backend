<?php

namespace Tests\Feature\App\Api\Admin\Affiliates\Controllers;

use App\Api\Admin\Affiliates\Requests\CreateAffiliateRequest;
use App\Api\Admin\Affiliates\Requests\UpdateAffiliateRequest;
use Domain\Accounts\Models\Account;
use Domain\Addresses\Models\Address;
use Domain\Affiliates\Actions\CreateAffiliate;
use Domain\Affiliates\Models\Affiliate;
use Domain\Affiliates\Models\AffiliateLevel;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class AffiliateControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_affiliate()
    {
        CreateAffiliateRequest::fake();

        $response = $this->postJson(route('admin.affiliate.store'))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(Affiliate::Table(), 1);
        $this->assertDatabaseHas(Affiliate::Table(), ['id' => $response['id']]);
    }

    /** @test */
    public function can_update_affiliate()
    {
        $affiliate = Affiliate::factory()->create();
        UpdateAffiliateRequest::fake(['name' => 'test']);

        $response = $this->putJson(route('admin.affiliate.update', [$affiliate]))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals($affiliate->refresh()->name, $response['name']);
    }

    /** @test */
    public function can_get_affiliate()
    {

        $account = Account::factory()->create();
        $affiliate = Affiliate::factory()->create(['account_id' => $account->id]);

        $response = $this->getJson(route('admin.affiliate.show', [$affiliate]))
            ->assertOk()
            ->assertJsonStructure(['id', 'name', 'email']);

        $this->assertEquals($account->id, $response['account']['id']);
    }

    /** @test */
    public function can_update_address()
    {
        $affiliate = Affiliate::factory()->create();
        $address = Address::factory()->create();

        $this->putJson(route('admin.affiliate-address.update', [$affiliate]), ['address_id' => $address->id])
            ->assertOk();

        $this->assertEquals($address->id, $affiliate->refresh()->address_id);
    }

    /** @test */
    public function can_archive_affiliate()
    {
        $affiliate = Affiliate::factory(5)->create();

        $this->deleteJson(route('admin.affiliate.destroy', [$affiliate->first()]))
            ->assertOk();

        $this->assertEquals(Affiliate::whereStatus(false)->count(), 1);
    }

    /** @test */
    public function can_restore_affiliate()
    {
        $affiliate = Affiliate::factory(5)->create(['status' => false]);

        $this->putJson(route('admin.affiliate-archive.restore', [$affiliate->first()]))
            ->assertOk();

        $this->assertEquals(Affiliate::whereStatus(true)->count(), 1);
    }

    /** @test */
    public function can_get_all_the_affiliate_level()
    {
        AffiliateLevel::factory(5)->create();
        $this->getJson(route('admin.affiliate-level.index'))
            ->assertOk()
            ->assertJsonStructure(
                ['*' => [
                    'id',
                    'name'
                ]
                ])->assertJsonCount(5);
    }

    /** @test */
    public function can_get_all_the_affiliate()
    {
        Affiliate::factory(5)->create(['status' => 1]);
        Affiliate::factory(4)->create(['status' => 0]);
        $response = $this->getJson(route('admin.affiliate.index', ["per_page" => 30]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                    'email'
                ]
            ]]);
        $this->assertEquals(5, count($response['data']));
    }

    public function can_search_affiliates()
    {
        Affiliate::factory()->create(['name' => 'test1', 'status' => false]);
        Affiliate::factory()->create(['name' => 'test2', 'status' => false]);
        Affiliate::factory()->create(['name' => 'not_match']);

        $this->getJson(
            route('admin.affiliate.index', ["per_page" => 5, "page" => 1, 'keyword' => 'test', 'status' => false]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                    'email'
                ]
            ]])->assertJsonCount(2, 'data');
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $data = CreateAffiliateRequest::factory()->create(['email' => '']);

        $this->postJson(route('admin.affiliate.store'), $data)
            ->assertJsonValidationErrorFor('email')
            ->assertStatus(422);

        $this->assertDatabaseCount(Affiliate::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(CreateAffiliate::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        CreateAffiliateRequest::fake();

        $this->postJson(route('admin.affiliate.store'))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(Affiliate::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        CreateAffiliateRequest::fake();

        $this->postJson(route('admin.affiliate.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(Affiliate::Table(), 0);
    }
}
