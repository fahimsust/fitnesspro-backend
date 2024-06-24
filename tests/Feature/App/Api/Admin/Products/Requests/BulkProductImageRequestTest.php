<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\BulkProductImageRequest;
use App\Api\Admin\Products\Requests\BulkProductRequest;
use Domain\Content\Models\Image;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class BulkProductImageRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private BulkProductImageRequest $request;
    private BulkProductRequest $parentRequest;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new BulkProductImageRequest();
        $this->parentRequest = new BulkProductRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'details_img_id' => [
                    'int',
                    'exists:' . Image::Table() . ',id',
                    'required',
                ],
            ]+$this->parentRequest->rules(),
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
