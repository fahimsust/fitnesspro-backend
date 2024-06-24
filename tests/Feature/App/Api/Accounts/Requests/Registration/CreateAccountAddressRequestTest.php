<?php

namespace Tests\Feature\App\Api\Accounts\Requests\Registration;

use App\Api\Accounts\Requests\Registration\CreateAccountAddressRequest;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use JMac\Testing\Traits\AdditionalAssertions;
use Illuminate\Validation\Rule;
use Tests\TestCase;


class CreateAccountAddressRequestTest extends TestCase
{
    use AdditionalAssertions;

    private CreateAccountAddressRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CreateAccountAddressRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'label' => ['string', 'max:55', 'required'],
                'company' => ['string', 'max:85', 'nullable'],
                'first_name' => ['string', 'max:55', 'required'],
                'last_name' => ['string', 'max:55', 'required'],
                'address_1' => ['string', 'max:100', 'required'],
                'address_2' => ['string', 'max:100', 'nullable'],
                'city' => ['string', 'max:35', 'required'],
                'state_id' => [
                    Rule::requiredIf(function () {
                        $requiredCountryIds = config('account_fields.required_state_country_id');
                        return in_array($this->request->input('country_id'), $requiredCountryIds);
                    }),
                    'numeric',
                    'nullable',
                    'exists:' . StateProvince::Table() . ',id'
                ],
                'country_id' => ['numeric', 'nullable', 'exists:' . Country::Table() . ',id'],
                'postal_code' => ['string', 'max:15', 'required'],
                'email' => ['string', 'email', 'max:85', 'nullable'],
                'phone' => ['string', 'max:35', 'nullable'],
                'is_residential' => ['min:0', 'max:1', 'nullable'],
            ],
            $this->request->rules()
        );
    }

    /** @test */
    public function can_authorize()
    {
        $this->assertTrue($this->request->authorize());
    }
}
