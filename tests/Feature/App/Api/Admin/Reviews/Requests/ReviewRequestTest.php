<?php

namespace Tests\Feature\App\Api\Admin\Reviews\Requests;

use App\Api\Admin\Reviews\Requests\ReviewRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Illuminate\Validation\Rule;


class ReviewRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ReviewRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ReviewRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'name' => ['string','max:85', 'required'],
                'rating' => ['int', 'required',Rule::in(['1','2','3','4','5'])],
                'comment' => ['string', 'required'],
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
