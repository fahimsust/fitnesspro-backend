<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Requests;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Enums\BulkEdit\SearchOptions;
use Illuminate\Validation\Rules\Enum;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class FindRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private FindRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new FindRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'search_option' => ['string',new Enum(SearchOptions::class),'required'],
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
