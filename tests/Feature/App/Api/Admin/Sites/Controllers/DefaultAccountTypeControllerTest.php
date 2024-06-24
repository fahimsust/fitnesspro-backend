<?php

namespace Tests\Feature\App\Api\Admin\Sites\Controllers;

use Domain\Accounts\Models\AccountType;
use Domain\Sites\Models\Site;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class DefaultAccountTypeControllerTest extends ControllerTestCase
{
    public Site $site;
    public AccountType $accountType;

    protected function setUp(): void
    {
        parent::setUp();

        $this->site = Site::factory()->create();
        $this->accountType = AccountType::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_update_default_account()
    {
        $this->postJson(
            route('admin.site.default-account-type', [$this->site]),
            [
                'account_type_id' => $this->accountType->id,
                'required_account_types' => [3, 4],
                'requireLogin'=>'none'
            ]
        )
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals($this->accountType->id, $this->site->refresh()->account_type_id);
        $this->assertEquals([3, 4], Site::first()->required_account_types);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {

        $this->postJson(
            route('admin.site.default-account-type', [$this->site]),
            [
                'account_type_id' => 0,
                'required_account_types' => [3, 4],
                'requireLogin'=>'none'
            ]
        )
            ->assertJsonValidationErrorFor('account_type_id')
            ->assertStatus(422);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(
            route('admin.site.default-account-type', [$this->site]),
            [
                'account_type_id' => $this->accountType->id,
                'required_account_types' => [3, 4],
                'requireLogin'=>'none'
            ]
        )
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertNotEquals($this->accountType->id, $this->site->refresh()->account_type_id);
    }
}
