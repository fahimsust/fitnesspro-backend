<?php

namespace Tests\Unit\Domain\Photos\Models;

use Domain\Accounts\Models\Account;
use Domain\Photos\Models\PhotoAlbum;
use Domain\Products\Models\Product\ProductAttribute;
use Tests\TestCase;

class PhotoAlbumTest extends TestCase
{


    /** @test */
    public function can_create_account_album()
    {
        $album = PhotoAlbum::factory()->create([
            'type_id' => Account::firstOrFactory()->id,
            'type' => 1,
        ]);

        $this->assertIsObject($album);
    }

    /** @test */
    public function can_create_product_album()
    {
        $album = PhotoAlbum::factory()->create([
            'type_id' => ProductAttribute::firstOrFactory()->option_id,
            'type' => 2,
        ]);

        $this->assertIsObject($album);
    }
}
