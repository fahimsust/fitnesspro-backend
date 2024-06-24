<?php

namespace Tests\Feature\App\Api\Accounts\Controllers;

use Database\Seeders\PhotoAlbumTypeSeeder;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountPhotoAlbum;
use Domain\Photos\Models\PhotoAlbum;
use function route;
use Tests\TestCase;

class AlbumControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PhotoAlbumTypeSeeder::class]);

        $this->apiTestToken();
    }

    /** @test */
    public function can_get_accounts_albums()
    {
        $anotherAccount = Account::factory()->create();
        $anotherAccountsAlbum = (new AccountPhotoAlbum($anotherAccount))->default();

        $primaryAccountAlbum = (new AccountPhotoAlbum($this->account))->default();

        $this->assertCount(2, PhotoAlbum::get());

        $response = $this->getJson(route('mobile.account.album.index', $this->account));

        $this->assertEquals(1, $response['albums']['total']);
    }
}
