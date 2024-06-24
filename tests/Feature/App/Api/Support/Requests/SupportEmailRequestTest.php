<?php

namespace Tests\Feature\App\Api\Support\Requests;

use App\Api\Accounts\Requests\Registration\RegistrationPaymentMethodRequest;
use App\Api\Accounts\Rules\IsValidSubscriptionPaymentMethod;
use App\Api\Support\Requests\SupportEmailRequest;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Payments\Models\PaymentMethod;
use Domain\Support\Models\SupportDepartment;
use Illuminate\Validation\Rule;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;


class SupportEmailRequestTest extends TestCase
{
    use AdditionalAssertions;

    private SupportEmailRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new SupportEmailRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'name' => ['string','required'],
                'email' => ['email','string','required'],
                'support_department_id' => ['integer', 'required', 'exists:' . SupportDepartment::table() . ',id'],
                'message' => ['string','required'],
                'origin' => ['string','required',Rule::in(['web', 'mobile'])],
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
