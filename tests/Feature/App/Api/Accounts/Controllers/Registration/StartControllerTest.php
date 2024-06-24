<?php

namespace Tests\Feature\App\Api\Accounts\Controllers\Registration;

use App\Api\Accounts\Requests\Registration\CreateAccountFromBasicInfoRequest;
use Domain\Accounts\Actions\CreateAccountFromBasicInfo;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Affiliates\Models\Affiliate;
use Tests\RequestFactories\App\Api\Accounts\Requests\Registration\CreateAccountFromBasicInfoRequestFactory;
use Tests\TestCase;
use function route;


class StartControllerTest extends TestCase
{
    /** @test */
    public function can_create_new_member()
    {
        $this->disableCookieEncryption();
        $affiliate = Affiliate::factory()->create();
        CreateAccountFromBasicInfoRequest::fake();
        $this->withCookie('affiliate_referral_id',$affiliate->id)->post(route('registration.start'))
            ->assertCreated()
            ->assertJsonFragment(['registration_id' => Registration::first()->id]);

        $this->assertDatabaseCount(Account::Table(), 1);
        $this->assertDatabaseCount(Registration::Table(), 1);
        $this->assertEquals($affiliate->id, Registration::first()->affiliate_id);
        $this->assertEquals(Registration::first()->id, session('registrationId'));
    }
    /** @test */
    public function can_get_registration_data()
    {
        $registration = Registration::factory()->create();
        session(['registrationId' => $registration->id]);
        CreateAccountFromBasicInfoRequest::fake();

        $this->getJson(route('registration.show'))
            ->assertOk()
            ->assertJsonStructure(
                [
                    'id','account_id','account','affiliate'
                ]
            );
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $data = CreateAccountFromBasicInfoRequestFactory::new()->create(['email' => '']);

        $this->postJson(route('registration.start'), $data)
            ->assertJsonValidationErrorFor('email')
            ->assertStatus(422);

        $this->assertDatabaseCount(Account::Table(), 0);
        $this->assertDatabaseCount(Registration::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(CreateAccountFromBasicInfo::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        CreateAccountFromBasicInfoRequest::fake();

        $this->postJson(route('registration.start'))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(Account::Table(), 0);
        $this->assertDatabaseCount(Registration::Table(), 0);
    }
}
