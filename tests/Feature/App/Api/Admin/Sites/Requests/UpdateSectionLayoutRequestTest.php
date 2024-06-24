<?php

namespace Tests\Feature\App\Api\Admin\Sites\Requests;

use App\Api\Admin\Sites\Requests\UpdateSectionLayoutRequest;
use Domain\Sites\Models\Layout\Layout;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Illuminate\Validation\Rule;


class UpdateSectionLayoutRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private UpdateSectionLayoutRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new UpdateSectionLayoutRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'layout_id' => ['numeric', 'exists:' . Layout::Table() . ',id', 'nullable'],
                'field_name' => ['string', 'required', Rule::in([
                    'search_layout_id',
                    'default_layout_id',
                    'default_category_layout_id',
                    'home_layout_id',
                    'default_product_layout_id',
                    'page_layout_id',
                    'affiliate_layout_id'
                ]),],
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
