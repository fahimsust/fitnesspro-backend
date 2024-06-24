<?php

namespace Tests\Feature\App\Api\Accounts\Controllers\Auth;

use Domain\Accounts\Mail\AccountForgotUsername;
use Illuminate\Support\Facades\Mail;
use Tests\Feature\App\Api\Accounts\Controllers\ControllerTestCase;
use function route;

class ForgotUsernameControllerTest extends ControllerTestCase
{
    /** @test */
    public function can_send_forgotten_username_to_email()
    {
        $account = $this->createTestAccount();

        Mail::fake();
        Mail::assertNothingSent();

        $response = $this->postJson(
            route('account.forgot-username'),
            ['email' => $account->email]
        )->assertOk();

        Mail::assertSent(AccountForgotUsername::class, function ($mail) use ($account) {
            return $mail->hasTo($account->email);
        });

        $this->assertEquals($account->user, $response['username']);
    }
}
