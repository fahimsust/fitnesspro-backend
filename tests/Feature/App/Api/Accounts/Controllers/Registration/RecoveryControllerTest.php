<?php

namespace Tests\Feature\App\Api\Accounts\Controllers\Registration;

use Database\Seeders\MessageTemplateSeeder;
use Domain\Accounts\Actions\Registration\CreateRegistrationRecoveryHash;
use Domain\Accounts\Enums\RegistrationStatus;
use Domain\Accounts\Models\Registration\Registration;
use Illuminate\Support\Facades\Mail;
use Support\Mail\MessageTemplateMailable;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use function route;


class RecoveryControllerTest extends TestCase
{
    private Registration $registration;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->seed([
            MessageTemplateSeeder::class
        ]);

        $this->registration = Registration::factory()->create();
    }

    /** @test */
    public function can_create_link_and_send_mail()
    {
        Mail::fake();

        $this->postJson(route('registration.recovery.hash'), [
            'email' => $this->registration->account->email
        ])
            ->assertCreated()
            ->assertJsonFragment(['account_id' => $this->registration->account->id]);

        $this->assertNotNull(Registration::first()->recovery_hash);
        Mail::assertQueued(
            MessageTemplateMailable::class,
            fn($mail) => $mail->to[0]['address'] == $this->registration->account->email
                && $mail->from[0]['address'] == $this->registration->account->site->email
        );
    }



    /** @test */
    public function can_validate_request_and_return_errors()
    {
        Mail::fake();

        $this->postJson(route('registration.recovery.hash'), ['email' => ""])
            ->assertJsonValidationErrorFor('email')
            ->assertStatus(422);

        $this->assertNull($this->registration->fresh()->recovery_hash);
        Mail::assertNotQueued(
            MessageTemplateMailable::class,
        );
    }

    /** @test */
    public function can_recover_from_hash()
    {
        CreateRegistrationRecoveryHash::run($this->registration);

        $this->getJson(route(
            'registration.recovery.recover',
            ['recovery_hash' => $this->registration->recovery_hash]
        ))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas('registrationId', $this->registration->id);
    }
}