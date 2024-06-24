<?php

namespace Tests\Unit\Domain\Sites\Actions;

use Domain\Sites\Actions\Offline\TakeSiteOnline;
use Domain\Sites\Models\Site;
use Tests\TestCase;


class TakeSiteOnlineTest extends TestCase
{
    /** @test */
    public function can_take_site_online()
    {
        $site = Site::factory()->create(['status' => false]);

        TakeSiteOnline::run($site);

        $this->assertTrue($site->fresh()->status);
    }
}
