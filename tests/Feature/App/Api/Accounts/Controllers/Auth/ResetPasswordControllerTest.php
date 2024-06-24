<?php

namespace Tests\Feature\App\Api\Accounts\Controllers\Auth;

use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use function route;
use Tests\Feature\App\Api\Accounts\Controllers\ControllerTestCase;

class ResetPasswordControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->account = $this->_createTestAccount();
    }

    /** @test */
    public function can_reset_password()
    {
        $token = Password::createToken($this->account);

        $newPassword = 'new-password';

        $response = $this->sendPost([
            'token' => $token,
            'email' => $this->account->email,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ])->assertOk();

        $this->assertEquals(
            trans(PasswordBroker::PASSWORD_RESET),
            $response->json('message')
        );

        $this->assertTrue(
            Auth::guard('web')
                ->validate([
                    'email' => $this->account->email,
                    'password' => $newPassword,
                ])
        );
    }

    /** @test */
    public function will_fail_if_passwords_mismatch()
    {
        $newPassword = 'new-password';

        $this->sendPost([
            'token' => 'invalid-token',
            'email' => 'wrong@email.com',
            'password' => $newPassword,
            'password_confirmation' => 'non-matching-password',
        ])->assertUnprocessable();
    }

    /** @test */
    public function will_fail_if_email_invalid()
    {
        $newPassword = 'new-password';

        $this->sendPost([
            'token' => 'invalid-token',
            'email' => 'wrong@email.com',
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ])->assertUnprocessable();
    }

    /** @test */
    public function will_fail_if_token_fails()
    {
        $newPassword = 'new-password';

        $this->sendPost([
            'token' => 'invalid-token',
            'email' => $this->account->email,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ])->assertUnprocessable();
    }

    protected function sendPost($data)
    {
        return $this->postJson(route('account.reset-password'), $data);
    }
}