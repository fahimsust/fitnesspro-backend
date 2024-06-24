<?php

namespace Tests\Feature\App\Api\Admin\Categories\Requests;

use App\Api\Admin\Categories\Requests\CategoryFilterSettingsRequest;
use Illuminate\Validation\Rules\Enum;
use JMac\Testing\Traits\AdditionalAssertions;
use Support\Enums\MatchAllAnyString;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CategoryFilterSettingsRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CategoryFilterSettingsRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CategoryFilterSettingsRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'rules_match_type' => [new Enum(MatchAllAnyString::class), 'required'],
                'show_types' => ['bool', 'required'],
                'show_brands' => ['bool', 'required'],
                'limit_min_price' => ['bool', 'required'],
                'min_price' => ['numeric', 'nullable'],
                'limit_max_price' => ['bool', 'required'],
                'max_price' => ['numeric', 'nullable'],
                'limit_days' => ['int', 'nullable'],
                'show_sale' => ['bool', 'nullable'],
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
