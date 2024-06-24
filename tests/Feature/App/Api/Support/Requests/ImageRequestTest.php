<?php

namespace Tests\Feature\App\Api\Support\Requests;

use App\Api\Support\Requests\ImageRequest;
use Domain\Support\Models\TmpFile;
use Illuminate\Validation\Rules\File;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;


class ImageRequestTest extends TestCase
{
    use AdditionalAssertions;

    private ImageRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new ImageRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'image' => ['integer', 'required', 'exists:' . TmpFile::table() . ',id'],
                'name' => ['string', 'max: 100', 'required'],
                'default_caption' => ['string', 'max: 100', 'nullable'],
                'inventory_image_id' => ['string', 'max: 100', 'nullable'],
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
