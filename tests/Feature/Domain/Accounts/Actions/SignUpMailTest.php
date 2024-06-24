<?php

namespace Tests\Feature\Domain\Accounts\Actions;

use Database\Seeders\MessageTemplateSeeder;
use Domain\Accounts\Actions\Registration\Mail\SendRegistrationEmailToAdmin;
use Domain\Accounts\Actions\Registration\Mail\SendEmailToCustomer;
use Domain\Accounts\Actions\Registration\Mail\SendVerificationEmail;
use Illuminate\Support\Facades\Mail;
use Support\Mail\MessageTemplateMailable;
use Tests\TestCase;

class SignUpMailTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            MessageTemplateSeeder::class
        ]);

        $this->createTestAccount();

        Mail::fake();
    }

    /** @test */
    public function can_send_email_to_admin()
    {
        SendRegistrationEmailToAdmin::run($this->account);

        Mail::assertQueued(
            MessageTemplateMailable::class,
            fn($mail) => $mail->to[0]['address'] == $this->account->site->email
                && $mail->from[0]['address'] == $this->account->email
        );
    }

    /** @test */
    public function can_send_email_to_customer()
    {
        SendEmailToCustomer::run($this->account);

        Mail::assertQueued(
            MessageTemplateMailable::class,
            fn($mail) => $mail->to[0]['address'] == $this->account->email
                && $mail->from[0]['address'] == $this->account->site->email
        );
    }

    /** @test */
    public function can_send_verification_email_to_customer()
    {
        SendVerificationEmail::run($this->account);

        Mail::assertNothingQueued();

        $this->account->type->verify_user_email = 1;

        SendVerificationEmail::run($this->account);

        Mail::assertQueued(
            MessageTemplateMailable::class,
            fn($mail) => $mail->to[0]['address'] == $this->account->email
                && $mail->from[0]['address'] == $this->account->site->email
        );
    }
}
