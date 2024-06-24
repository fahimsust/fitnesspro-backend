<?php

namespace Tests\Feature\App\Api\Admin\Accounts\Controllers;

use Domain\Accounts\Models\Account;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Tests\Feature\Traits\HasTestAccount;

use function route;

class AccountAdminLoginControllerTest extends ControllerTestCase
{
    use HasTestAccount;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_login_to_account()
    {
        $account = $this->_createTestAccount();

        $this->postJson(route('admin.account-login.store'), ['account_id' => $account->id])
            ->assertOk();
        // $this->getJson(route('account.me'))
        //     ->assertOk()
        //     ->assertJson(['data' => ['email' => 'test@test.com']]);
        $this->postJson(route('account.logout'));
        $account = Account::factory()->create(['email' => 'test_new@gmail.com']);
        $this->postJson(route('admin.account-login.store'), ['account_id' => $account->id])
            ->assertOk();
        $this->assertAuthenticatedAs($account, 'web');
        $this->getJson(route('account.me'))
            ->assertOk()
            ->assertJson(['data' => ['email' => 'test_new@gmail.com']]);
    }
}
