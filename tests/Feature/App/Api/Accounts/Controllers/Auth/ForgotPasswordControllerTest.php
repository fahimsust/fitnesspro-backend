<?php

namespace Tests\Feature\App\Api\Accounts\Controllers\Auth;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\TestResponse;
use function route;
use Tests\Feature\App\Api\Accounts\Controllers\ControllerTestCase;

class ForgotPasswordControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->account = $this->_createTestAccount();
    }

    /** @test */
    public function can_submit_forgot_password()
    {
        Notification::fake();

        $this->sendPost(['email' => $this->account->email])
            ->assertOk();

        Notification::assertSentToTimes(
            $this->account,
            ResetPassword::class
        );
    }

    /** @test */
    public function will_fail_if_email_not_found()
    {
        $this->sendPost(['email' => 'not-right-email@test.com'])
            ->assertUnprocessable();
    }

    protected function sendPost($data): TestResponse
    {
        return $this->postJson(
            route('account.forgot-password'),
            $data
        );
    }
}
