<?php

namespace Tests\Feature\App\Api\Admin\Categories\Requests;

use App\Api\Admin\Categories\Requests\CategoryMenuSettingsRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CategoryMenuSettingRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CategoryMenuSettingsRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CategoryMenuSettingsRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'rank' => ['int', 'required'],
                'show_in_list' => ['bool', 'required'],
                'menu_class' => ['string','max:55', 'nullable'],
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
