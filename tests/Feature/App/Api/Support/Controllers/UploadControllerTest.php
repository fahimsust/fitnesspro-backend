<?php

namespace Tests\Feature\App\Api\Support\Controllers;

use Domain\Support\Models\TmpFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use function route;


class UploadControllerTest extends TestCase
{
    /** @test */
    public function can_upload_file()
    {
        Storage::fake('s3');
        $file = UploadedFile::fake()->image('avatar.jpg');
        $response = $this->postJson(route('upload-file.store'),['filepond'=>$file,'name'=>'avatar'])
            ->assertCreated();
        // Assert the file was stored...
        Storage::disk('s3')->assertExists($response->original->filename);
        $this->assertDatabaseCount(TmpFile::Table(),1);
    }

}
