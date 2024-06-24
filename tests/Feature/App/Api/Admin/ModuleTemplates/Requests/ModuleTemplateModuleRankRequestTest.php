<?php

namespace Tests\Feature\App\Api\Admin\ModuleTemplates\Requests;

use App\Api\Admin\ModuleTemplates\Requests\ModuleTemplateModuleRankRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ModuleTemplateModuleRankRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ModuleTemplateModuleRankRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ModuleTemplateModuleRankRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'rank' => ['numeric', 'required']
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
