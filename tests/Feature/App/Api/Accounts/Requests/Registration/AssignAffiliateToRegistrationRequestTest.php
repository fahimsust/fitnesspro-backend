<?php

namespace Tests\Feature\App\Api\Accounts\Requests\Registration;

use App\Api\Accounts\Requests\Registration\AssignAffiliateToRegistrationRequest;
use Domain\Affiliates\Models\Affiliate;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;


class AssignAffiliateToRegistrationRequestTest extends TestCase
{
    use AdditionalAssertions;

    private AssignAffiliateToRegistrationRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new AssignAffiliateToRegistrationRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'affiliate_id' => ['integer', 'required', 'exists:' . Affiliate::table() . ',id'],
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
