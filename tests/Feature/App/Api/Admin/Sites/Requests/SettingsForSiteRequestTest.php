<?php

namespace Tests\Feature\App\Api\Admin\Sites\Requests;

use App\Api\Admin\Sites\Requests\DefaultAccountTypeRequest;
use App\Api\Admin\Sites\Requests\SettingsForSiteRequest;
use Domain\Accounts\Models\AccountType;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class SettingsForSiteRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private SettingsForSiteRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new SettingsForSiteRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'home_show_categories_in_body'=>['boolean','required'],
                'home_feature_show'=>['boolean','required'],
                'catalog_show_categories_in_body'=>['boolean','required'],
                'catalog_feature_show'=>['boolean','required'],
                'default_show_categories_in_body'=>['boolean','required'],
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
