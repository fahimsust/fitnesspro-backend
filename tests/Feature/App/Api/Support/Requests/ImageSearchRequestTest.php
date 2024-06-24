<?php

namespace Tests\Feature\App\Api\Support\Requests;

use App\Api\Support\Requests\ImageSearchRequest;
use Domain\Products\Models\Product\Product;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;


class ImageSearchRequestTest extends TestCase
{
    use AdditionalAssertions;

    private ImageSearchRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new ImageSearchRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'keyword' => ['string', 'nullable'],
                'product_id' => [
                    'int',
                    'exists:' . Product::Table() . ',id',
                    'nullable',
                ],
            ],
            $this->request->rules()
        );
    }

    /** @test */
    public function can_authorize()
    {
        $this->assertTrue($this->request->authorize());
    }


}
