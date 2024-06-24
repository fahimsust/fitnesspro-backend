<?php

namespace Tests\Feature\App\Api\Admin\Affiliates\Requests;

use App\Api\Admin\Affiliates\Requests\UpdateAffiliateRequest;
use Domain\Accounts\Models\Account;
use Domain\Addresses\Models\Address;
use Domain\Affiliates\Models\AffiliateLevel;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class UpdateAffiliateRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private UpdateAffiliateRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new UpdateAffiliateRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'email' => ['string', 'email', 'max:85', 'required'],
                'password' => ['max:255', 'min:8', 'confirmed'],
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
