<?php

namespace Tests\Feature\App\Api\Admin\Controllers\Auth;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\TestResponse;
use function route;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

class ForgotPasswordControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createTestAdminUser();
    }

    /** @test */
    public function can_submit_forgot_password()
    {
        Notification::fake();

        $this->sendPost(['email' => $this->user->email])
            ->assertOk();

        Notification::assertSentToTimes(
            $this->user,
            ResetPassword::class
        );
    }

    /** @test */
    public function will_fail_if_email_not_found()
    {
        $this->sendPost(['email' => 'not-right-email@domain.com'])
            ->assertUnprocessable();

//        $response->assertJsonValidationErrors('email');
    }

    protected function sendPost($data): TestResponse
    {
        return $this->postJson(
            route('admin.forgot-password'),
            $data
        );
    }
}
