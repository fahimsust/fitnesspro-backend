<?php

namespace Tests\Feature\App\Api\Accounts\Controllers\Auth\Sanctum;

use Domain\Accounts\Exceptions\AccountLoginException;
use Illuminate\Support\Facades\Auth;
use function route;
use Tests\Feature\App\Api\Accounts\Controllers\ControllerTestCase;

class SanctumAuthControllerTest extends ControllerTestCase
{
    /** @test */
    public function can_get_auth_failure()
    {
        $this->withoutExceptionHandling()
            ->expectException(AccountLoginException::class);

        $this->postJson(route('account.login'), ['username' => 'invalid-user', 'password' => 'invalid-pass']);
    }

    /** @test */
    public function can_auth()
    {
        $account = $this->_createTestAccount();

        $response = $this->postJson(route('account.login'), [
            //            'email' => $account->email,
            'username' => $account->user,
            'password' => $this->password,
        ])->assertOk();

        $this->assertAuthenticatedAs($account, 'web');
    }

    /** @test */
    public function can_auth_and_get_me()
    {
        $account = $this->_createTestAccount();
        $oldLastLogin = $account->lastlogin_at;

        $this->postJson(
            route('account.login'),
            [
                'username' => $account->user,
                'password' => $this->password,
            ]
        )->assertOk();

        $this->assertNotEquals((string) $oldLastLogin, (string) $account->fresh()->lastlogin_at);

        $this->getJson(route('account.me'))
            ->assertOk()
            ->assertJson(['data' => ['email' => $account->email]]);
    }

    /** @test */
    public function remember_token_works()
    {
        $account = $this->_createTestAccount();

        $response = $this->postJson(
            route('account.login'),
            [
                'username' => $account->user,
                'password' => $this->password,
                'remember' => true,
            ]
        )->assertOk();

        $this->assertAuthenticated('web');

        $response->assertCookie(Auth::guard('web')->getRecallerName());
    }

    /** @test */
    public function can_logout()
    {
        $account = $this->_createTestAccount();

        $this->actingAs($account, 'web');

        $response = $this->postJson(route('account.logout'))
            ->assertNoContent();

        $this->assertGuest('web');
        $response->assertSessionHasNoErrors();
    }
}
