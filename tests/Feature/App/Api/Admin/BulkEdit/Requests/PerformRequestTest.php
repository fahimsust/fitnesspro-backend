<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Requests;

use Domain\Products\Models\Product\Product;
use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Domain\Products\Enums\BulkEdit\ActionList;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class PerformRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private PerformRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new PerformRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'ids' => [
                    'array',
                    'required',
                ],
                'ids.*' => [
                    'int',
                    Rule::exists(Product::Table(), 'id')->where(function ($query) {
                        return $query->whereNull('deleted_at');
                    }),
                ],
                'action_name' => ['string',new Enum(ActionList::class),'required'],
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
