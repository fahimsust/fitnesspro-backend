<?php

namespace Tests\Feature\App\Api\Accounts\Requests\Registration;

use App\Api\Accounts\Requests\Registration\CreateAccountFromBasicInfoRequest;
use App\Api\Accounts\Rules\PasswordRule;
use Domain\Accounts\Models\Account;
use Illuminate\Support\Facades\Config;
use JMac\Testing\Traits\AdditionalAssertions;
use Support\Helpers\CustomValidation;
use Support\Traits\HasAccountEmailUserValidation;
use Tests\TestCase;


class CreateAccountFromBasicInfoRequestTest extends TestCase
{
    use AdditionalAssertions, HasAccountEmailUserValidation;

    private CreateAccountFromBasicInfoRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CreateAccountFromBasicInfoRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'username' => $this->getUsernameValidation(),
                'email' => $this->getEmailValidation(),
                'password' => ['max:60', 'min:8', 'confirmed', 'required', new PasswordRule],
                'first_name' => ['string', 'max:55', 'required'],
                'last_name' => ['string', 'max:55', 'required'],
                'phone' => ['string', 'max:35', 'nullable'],
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
    public function check_password_rule()
    {
        $this->postJson(
            route('registration.start'),
            CreateAccountFromBasicInfoRequest::factory()->create([
                'password' => "123456F!",
                'password_confirmation' => "123456F!"
            ])
        )
            ->assertJsonValidationErrorFor('password')
            ->assertJsonFragment(["message" => "Password must contain at least one lowercase letter"])
            ->assertStatus(422);

        $this->assertDatabaseCount(Account::Table(), 0);
    }

    /** @test */
    public function check_black_list_email()
    {
        Config::set('accounts.blacklist_email_tld', ["home"]);

        $this->postJson(
            route('registration.start'),
            CreateAccountFromBasicInfoRequest::factory()->create([
                'email' => "fahimcse@gmail.home",
                'email_confirmation' => "fahimcse@gmail.home"
            ])
        )
            ->assertJsonValidationErrorFor('email')
            ->assertJsonFragment(["message" => "Sorry, our servers are not available.  Please contact us if you have continued issues."])
            ->assertStatus(422);

        $this->assertDatabaseCount(Account::Table(), 0);
    }

    /** @test */
    public function check_black_list_ip()
    {
        Config::set('accounts.blacklist_ip', [CustomValidation::getUserIpAddr()]);

        $this->postJson(
            route('registration.start'),
            CreateAccountFromBasicInfoRequest::factory()->create()
        )
            ->assertJsonValidationErrorFor('email')
            ->assertJsonFragment(["message" => "Sorry, our servers are not available.  Please contact us if you have continued issues."])
            ->assertStatus(422);

        $this->assertDatabaseCount(Account::Table(), 0);
    }
}
