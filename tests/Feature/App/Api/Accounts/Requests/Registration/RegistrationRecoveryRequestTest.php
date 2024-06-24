<?php

namespace Tests\Feature\App\Api\Accounts\Requests\Registration;

use App\Api\Accounts\Requests\Registration\RegistrationRecoveryRequest;
use App\Api\Accounts\Rules\CheckRegistrationOpen;
use Domain\Accounts\Enums\RegistrationStatus;
use Domain\Accounts\Models\Account;

use Domain\Accounts\Models\Registration\Registration;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response as FacadesResponse;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;


class RegistrationRecoveryRequestTest extends TestCase
{
    use AdditionalAssertions;

    private RegistrationRecoveryRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new RegistrationRecoveryRequest();
        $this->createTestAccount();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'email' => ['email', 'required', 'exists:' . Account::table() . ',email']
            ],
            $this->request->rules()
        );
    }

    /** @test */
    public function can_authorize()
    {
        $this->assertTrue($this->request->authorize());
    }

    /** @test */
    public function can_check_registration_close_and_return_exception()
    {
        $registration = Registration::factory()->create();
        $registration->update([
            'status' => RegistrationStatus::CLOSE
        ]);

        $this->postJson(route('registration.recovery.hash'), ['email' => $registration->account->email])
            ->assertNotFound()
            ->assertJsonFragment(["message" => __("Registration has already been completed")]);

        $this->assertNull($registration->fresh()->recovery_hash);
    }

}
