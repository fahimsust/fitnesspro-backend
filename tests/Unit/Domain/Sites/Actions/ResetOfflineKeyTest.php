<?php

namespace Tests\Unit\Domain\Sites\Actions;

use Domain\Sites\Actions\Offline\ResetOfflineKey;
use Domain\Sites\Models\Site;
use Tests\TestCase;


class ResetOfflineKeyTest extends TestCase
{
    /** @test */
    public function can_take_site_offline()
    {
        $site = Site::factory()->create([
            'offline_key' => 100
        ]);
        $this->assertEquals(100, $site->refresh()->offline_key);
        ResetOfflineKey::run($site);
        $this->assertNotEquals(100, $site->refresh()->offline_key);
    }
}
