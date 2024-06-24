<?php

namespace Tests\Feature\App\Api\Accounts\Controllers\Auth\Firebase;

use Domain\Accounts\Exceptions\AccountLoginException;
use function route;
use Tests\Feature\App\Api\Accounts\Controllers\ControllerTestCase;

class FirebaseAuthControllerTest extends ControllerTestCase
{
    /** @test */
    public function can_get_firebase_auth_failure()
    {
        $this->withoutExceptionHandling()
            ->expectException(AccountLoginException::class); //"Account does not match token");

        $this->postJson(route('firebase.auth.store'), ['user' => 'invalid-user', 'pass' => 'invalid-pass']);
    }

    /** @test */
    public function can_get_firebase_auth_success()
    {
        $account = $this->_createTestAccount();

        $response = $this->postJson(route('firebase.auth.store'), [
            'user' => $account->user,
            'pass' => $this->password,
        ])->assertOk();

        $this->assertNotNull($response['token']);
    }

    /** @test */
    public function can_auth_verify_via_controller()
    {
        $account = $this->_createTestAccount();
        $oldLastLogin = $account->last_login;

        $authResponse = $this->postJson(
            route('firebase.auth.store'),
            ['user' => $account->user, 'pass' => $this->password]
        )->assertOk();

        $this->assertNotEquals($oldLastLogin, $account->fresh()->last_login);

        $this->assertNotNull($authResponse['token']);

        $idResponse = $this->getJson(route('firebase.auth.create', ['token' => $authResponse['token']]));

        $verifyResponse = $this->getJson(route('firebase.auth.show', [$idResponse['id_token']]))
            ->assertOk();

        $this->assertTrue($verifyResponse['is_account']);
        $this->assertTrue($verifyResponse['verified']);
        $this->assertEquals($account->id, $verifyResponse['user_id']);
    }
}
