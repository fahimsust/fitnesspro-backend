<?php

namespace Tests\Feature\App\Api\Accounts\Controllers;

use function __;
use Domain\Accounts\Models\AccountPhotoAlbum;
use Domain\Photos\Models\Photo;
use Domain\Photos\Models\PhotoAlbum;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function route;
use Support\Services\DigitalOcean\Spaces;
use Tests\TestCase;

class PhotoControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('spaces');
    }

    protected function partialMockWithParams($class, $params = [])
    {
        $mock = \Mockery::mock($class, $params)->makePartial();

        return $mock;
    }

    protected function bindPartialMock($class, $mock)
    {
        $this->app->bind($class, function () use ($mock) {
            return $mock;
        });
    }

    /**
     * @test
     */
    public function can_upload_file_to_spaces()
    {
        $this->apiTestToken();

        $uploadFile = UploadedFile::fake()->image('avatar.jpg', 2000, 1000);
        $response = $this->postJson(
            route('mobile.account.photo.store', $this->account),
            [
                'file' => $uploadFile,
                'title' => __('Test photo title'),
            ]
        )->assertOk();
//        dd($response);

        $photo = Photo::first();

        Storage::disk('spaces')->assertExists('catalog/photos/'.$photo->id.'_'.$uploadFile->hashName());
    }

    /** @test */
    public function can_upload_file_to_specific_album_within_account()
    {
        $this->apiTestToken();

        $defaultAlbum = (new AccountPhotoAlbum($this->account))
            ->default();

        $album = PhotoAlbum::create([
            'type_id' => $this->account->id,
            'type' => 1,
            'name' => 'Test Personal Album',
            'description' => '',
            'recent_photo_id' => 0,
            'photos_count' => 0,
            'updated' => now(),
        ]);

        $uploadFile = UploadedFile::fake()->image('avatar.jpg', 2000, 1000);
        $response = $this->postJson(
            route('mobile.account.photo.store', $this->account),
            [
                'file' => $uploadFile,
                'title' => __('Personal Album Photo'),
                'album_id' => $album->id,
            ]
        );

        $photo = Photo::first();

        Storage::disk('spaces')->assertExists('catalog/photos/'.$photo->id.'_'.$uploadFile->hashName());
    }

    /** @test */
    public function cannot_upload_photo_to_album_from_another_account()
    {
        $this->apiTestToken();

        $anotherAccountsAlbum = PhotoAlbum::factory()->create([
            'type_id' => 5,
            'type' => 1,
            'name' => 'Account 5\'s Personal Album',
        ]);

        $this->withoutExceptionHandling()
            ->expectExceptionCode(403);

        $uploadFile = UploadedFile::fake()->image('should-fail.jpg', 2000, 1000);
        $response = $this->postJson(
            route('mobile.account.photo.store', $this->account),
            [
                'file' => $uploadFile,
                'title' => __('Should Fail Photo'),
                'album_id' => $anotherAccountsAlbum->id,
            ]
        );
    }

    /** @test */
    public function if_photo_upload_fails_delete_photo_record()
    {
        $this->apiTestToken();

//        $this->withExceptionHandling();
        $uploadFile = UploadedFile::fake()->image('avatar.jpg', 2000, 1000);

        $this->partialMock(Spaces::class)
            ->shouldReceive('push')
            ->once()
            ->andThrow(new \Exception('test', 0)); //induce error to confirm photo is deleted

        $this->assertCount(0, Photo::all());

        try {
            $response = $this->postJson(
                route('mobile.account.photo.store', $this->account),
                [
                    'file' => $uploadFile,
                    'title' => __('Test photo title'),
                ]
            );
        } catch (\Exception $exception) {
            $this->assertEquals(0, $exception->getCode());
        }

        $this->assertCount(0, Photo::all());
    }
}
