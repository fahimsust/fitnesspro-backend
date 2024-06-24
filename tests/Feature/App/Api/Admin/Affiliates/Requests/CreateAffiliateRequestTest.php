<?php

namespace Tests\Feature\App\Api\Admin\Affiliates\Requests;

use App\Api\Admin\Affiliates\Requests\CreateAffiliateRequest;
use Domain\Accounts\Models\Account;
use Domain\Affiliates\Models\AffiliateLevel;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CreateAffiliateRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CreateAffiliateRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CreateAffiliateRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'email' => ['string', 'email', 'max:85', 'required'],
                'password' => ['max:255', 'min:8', 'confirmed', 'required'],
                'name' => ['string', 'max:155', 'required'],
                'affiliate_level_id' => ['numeric', 'exists:' . AffiliateLevel::Table() . ',id', 'nullable'],
                'account_id' => ['numeric', 'exists:' . Account::Table() . ',id', 'nullable'],
            ],
            $this->request->rules()
        );
    }

    /** @test */
    public function can_authorize()
    {
        $this->createAndAuthAdminUser();

        $this->assertTrue($this->request->authorize());
    }
}
