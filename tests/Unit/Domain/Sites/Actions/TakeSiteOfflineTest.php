<?php

namespace Tests\Unit\Domain\Sites\Actions;

use Domain\Sites\Actions\Offline\TakeSiteOffline;
use Domain\Sites\Models\Site;
use Tests\TestCase;


class TakeSiteOfflineTest extends TestCase
{
    /** @test */
    public function can_take_site_offline()
    {
        $site = Site::factory()->create([
            'status' => true,
            'offline_key' => null
        ]);

        $this->assertNull($site->offline_key);

        TakeSiteOffline::run($site);

        $this->assertFalse($site->refresh()->status);
        $this->assertNotNull($site->offline_key);
    }
}
