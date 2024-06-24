<?php

namespace Tests\Unit\Domain\Photos\Models;

use Domain\Photos\Models\Photo;
use Tests\TestCase;

class PhotoTest extends TestCase
{


    /** @test */
    public function can_create_photo()
    {
        $photo = Photo::factory()->create();

        $this->assertIsObject($photo);
    }
}
