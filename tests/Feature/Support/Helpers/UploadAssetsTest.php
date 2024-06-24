<?php

namespace Tests\Feature\Support\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadAssetsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();


    }

//   /** @test */
//   public function can_upload_file_to_aws_s3()
//   {
//       //upload ./tests/test-image.jpg to aws s3
//       $file = File::get('./tests/test-image.jpg');
//
//       Storage::disk('s3')->put('image/test-image5.jpg', $file, 'public');
//   }
//
//    /** @test */
//    public function can_delete()
//    {
//        Storage::disk('s3')->delete('test/test-image.jpg');
//    }
}
