<?php

namespace Tests\Feature\App\Api\Admin\Categories\Requests;

use App\Api\Admin\Categories\Requests\CategorySettingsRequest;
use Domain\Products\Models\Category\CategorySettingsTemplate;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CategorySettingsRequestTest extends ControllerTestCase
{
    use AdditionalAssertions;

    private CategorySettingsRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CategorySettingsRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'settings_template_id' => ['int', 'exists:' . CategorySettingsTemplate::Table() . ',id', 'nullable'],
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
