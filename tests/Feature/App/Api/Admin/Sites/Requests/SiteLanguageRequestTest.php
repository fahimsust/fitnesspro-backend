<?php

namespace Tests\Feature\App\Api\Admin\Sites\Requests;

use App\Api\Admin\Sites\Requests\SiteLanguageRequest;
use Domain\Locales\Models\Language;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class SiteLanguageRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private SiteLanguageRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new SiteLanguageRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'language_id' => ['numeric', 'exists:' . Language::Table() . ',id', 'required'],
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
