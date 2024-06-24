<?php

namespace Tests\Feature\App\Api\Admin\Sites\Requests;

use App\Api\Admin\Sites\Requests\UpdateOfflineSettingsRequest;
use Domain\Sites\Models\Layout\Layout;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class UpdateOfflineSettingsRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private UpdateOfflineSettingsRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new UpdateOfflineSettingsRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'offline_message' => ['string', 'required'],
                'offline_layout_id' => ['numeric', 'exists:' . Layout::Table() . ',id', 'required'],
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
