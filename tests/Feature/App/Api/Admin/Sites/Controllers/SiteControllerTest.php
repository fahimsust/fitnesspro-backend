<?php

namespace Tests\Feature\App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\CreateSiteRequest;
use App\Api\Admin\Sites\Requests\UpdateSiteRequest;
use Domain\Discounts\Models\Rule\Condition\ConditionSite;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Sites\Actions\CreateSite;
use Domain\Sites\Models\Site;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class SiteControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
    }

    /** @todo  */
    public function can_create_new_site()
    {
        CreateSiteRequest::fake();

        $response = $this->postJson(route('admin.site.store'))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(Site::Table(), 1);
        $this->assertDatabaseHas(Site::Table(), ['id' => $response['id']]);
    }

    /** @test */
    public function can_get_all_the_site()
    {
        Site::factory(5)->create();
        $this->getJson(route('admin.site.index'))
            ->assertOk()
            ->assertJsonCount(5)
            ->assertJsonStructure(
                [
                    '*' => [
                        'id',
                        'name',
                        'email'
                    ]
                ]
            );

        $this->assertDatabaseCount(Site::Table(), 5);
    }

    /** @test */
    public function can_search_site_for_discount_condition()
    {
        $discountCondition = DiscountCondition::factory()->create();
        $sites = Site::factory(10)->create();
        ConditionSite::factory()->create(['site_id' => $sites[0]->id, 'condition_id' => $discountCondition->id]);
        ConditionSite::factory()->create(['site_id' => $sites[1]->id, 'condition_id' => $discountCondition->id]);
        ConditionSite::factory()->create(['site_id' => $sites[2]->id, 'condition_id' => $discountCondition->id]);
        $this->getJson(
            route('admin.site.index', ['condition_id' => $discountCondition->id]),
        )
            ->assertOk()
            ->assertJsonStructure(
                [
                    '*' => [
                        'id',
                        'name',
                        'email'
                    ]
                ]
            )->assertJsonCount(7);
    }

    /** @test */
    public function can_update_site()
    {
        $site = Site::factory()->create();
        UpdateSiteRequest::fake(['name' => 'test']);

        $response = $this->putJson(route('admin.site.update', [$site]))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals($site->refresh()->name, $response['name']);
    }

//    /** @test */
//    public function can_delete_site()
//    {
//        $site = Site::factory(5)->create();
//
//        $this->deleteJson(route('admin.site.delete', [$site->first()]))
//            ->assertOk();
//
//        $this->assertDatabaseCount(Site::Table(), 4);
//    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $data = CreateSiteRequest::factory()->create(['email' => '']);

        $this->postJson(route('admin.site.store'), $data)
            ->assertJsonValidationErrorFor('email')
            ->assertStatus(422);

        $this->assertDatabaseCount(Site::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(CreateSite::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

            CreateSiteRequest::fake();

        $this->postJson(route('admin.site.store'))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(Site::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        CreateSiteRequest::fake();

        $this->postJson(route('admin.site.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(Site::Table(), 0);
    }
}
