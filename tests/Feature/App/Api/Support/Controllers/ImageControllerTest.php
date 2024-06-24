<?php

namespace Tests\Feature\App\Api\Support\Controllers;

use Domain\Content\Models\Image;
use Domain\Support\Models\TmpFile;
use Tests\TestCase;
use function route;


class ImageControllerTest extends TestCase
{
    /** @test */
    public function can_search_images()
    {
        Image::factory(5)->create(['name'=>'test1']);
        Image::factory(5)->create(['name'=>'not_matched']);
        $this->getJson(route('image.index',['keyword'=>'test']))
            ->assertOk()
            ->assertJsonStructure(['data'=>[
                '*' => [
                    'id',
                    'filename',
                    'name'
                ]
            ]])->assertJsonCount(5,'data');
    }

    /** @test */
    public function can_upload_image()
    {
        $tmpFile = new TmpFile();
        $tmpFile->filename = 'avatar.jpg';
        $tmpFile->save();
        $this->postJson(route('image.store'),['image'=>$tmpFile->id,'name'=>'avatar'])
            ->assertCreated()
            ->assertJsonStructure(['id','filename','name']);

        $this->assertDatabaseCount(Image::Table(), 1);
    }


}
