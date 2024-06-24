<?php

namespace Tests\Feature\App\Api\Admin\Controllers\Auth\Sanctum;

use Domain\AdminUsers\Exceptions\AdminLoginException;
use Illuminate\Support\Facades\Auth;
use function route;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

class SanctumAuthControllerTest extends ControllerTestCase
{
    /** @test */
    public function can_get_auth_failure()
    {
        $this->withoutExceptionHandling()
            ->expectException(AdminLoginException::class);

        $this->postJson(route('admin.login'), ['email' => 'invalid@email.com', 'password' => 'invalid-pass']);
    }

    /** @test */
    public function can_auth()
    {
        $user = $this->createTestAdminUser();

        $this->postJson(route('admin.login'), [
            'email' => $user->email,
            'password' => $this->password,
        ])->assertOk();

        $this->assertAuthenticatedAs($user, 'admin');
    }

    /** @test */
    public function can_auth_and_get_me()
    {
        $account = $this->createTestAdminUser();

        $this->postJson(
            route('admin.login'),
            [
                'email' => $account->email,
                'password' => $this->password,
            ]
        )->assertOk();

        $this->getJson(route('admin.me'))
            ->assertOk()
            ->assertJson(['data' => ['email' => $account->email]]);
    }

    /** @test */
    public function remember_token_works()
    {
        $account = $this->createTestAdminUser();

        $response = $this->postJson(
            route('admin.login'),
            [
                'email' => $account->email,
                'password' => $this->password,
                'remember' => true,
            ]
        )->assertOk();

        $this->assertAuthenticated('admin');

        $response->assertCookie(
            Auth::guard('admin')
                ->getRecallerName()
        );
    }

    /** @test */
    public function can_logout()
    {
        $account = $this->createTestAdminUser();

        $this->actingAs($account, 'admin');

        $response = $this->postJson(route('admin.logout'))
            ->assertNoContent();

        $this->assertGuest('admin');
        $response->assertSessionHasNoErrors();
    }
}
