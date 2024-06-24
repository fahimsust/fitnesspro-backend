<?php

namespace Tests\Feature\App\Api\Admin\Accounts\Controllers;

use Domain\Accounts\Models\Account;
use Domain\Photos\Models\Photo;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Illuminate\Support\Facades\Storage;
use function route;

class AccountPhotoControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    /** @test */
    public function can_list_account_photos()
    {
        $account = Account::factory()->create();
        $photo = Photo::factory()->create(['addedby' => $account->id]);
        $account->update([
            'photo_id' => $photo->id,
        ]);
        Photo::factory(5)->create(['addedby' => $account->id]);

        $response = $this->getJson(route('admin.account-photo.index', ['account_id' => $account->id]));

        $response->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'added',
                    'title',
                    'img',
                    'approved',
                    'account_profile_image'
                ]
            ])
            ->assertJsonCount(6);

        // Check that the specific photo has a non-null 'account_profile_image'
        $response->assertJsonFragment([
            'id' => $photo->id,
            'account_profile_image' => $response->json()[0]['account_profile_image']
        ]);
    }
    /** @test */
    public function can_delete_account_photo()
    {
        Storage::fake('s3');
        $photo = Photo::factory()->create();

        // Optionally upload a file to the fake storage
        Storage::disk('s3')->put($photo->img, 'Dummy content');

        $this->deleteJson(route('admin.account-photo.destroy', $photo))
            ->assertOk();

        $this->assertDatabaseCount(Photo::Table(), 0);
        Storage::disk('s3')->assertMissing($photo->img);
    }
    /** @test */
    public function can_update_photo_approved()
    {
        $photo = Photo::factory()->create(['approved' => false]);

        $this->putJson(route('admin.account-photo.update', [$photo]), ['approved' => true])
            ->assertCreated();

        $this->assertTrue($photo->refresh()->approved);
    }
}
