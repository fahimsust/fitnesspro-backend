<?php

namespace Tests\Feature\App\Api\Admin\Sites\Requests;

use App\Api\Admin\Sites\Requests\SiteCurrencyRequest;
use Domain\Locales\Models\Currency;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class SIteCurrencyRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private SiteCurrencyRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new SiteCurrencyRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'currency_id' => ['numeric', 'exists:' . Currency::Table() . ',id', 'required'],
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
