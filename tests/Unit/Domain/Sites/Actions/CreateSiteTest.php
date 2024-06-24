<?php

namespace Tests\Unit\Domain\Sites\Actions;

use App\Api\Admin\Sites\Requests\CreateUpdateSiteRequest;
use Domain\Sites\Actions\CreateSite;
use Domain\Sites\Models\Site;
use Tests\TestCase;


class CreateSiteTest extends TestCase
{
    /** @todo */
    public function can_create_site()
    {
        $siteRequest = $this->postRequestFactory(
            CreateUpdateSiteRequest::class
        );

        $site = CreateSite::run($siteRequest);

        $this->assertInstanceOf(Site::class, $site);
        $this->assertModelExists($site);
        $this->assertEquals(1, Site::count());
    }
}
