<?php

namespace Tests\Feature\App\Api\Resort\Controllers;

use Domain\Accounts\Models\Specialty;
use Domain\Content\Models\Image;
use Domain\Photos\Models\Photo;
use Domain\Products\Models\Product\ProductImage;
use Domain\Products\Models\Product\Specialties\ProductSpecialty;
use Illuminate\Auth\AuthenticationException;
use Tests\Feature\Domain\Resorts\ResortTestCase;
use function route;

class ResortControllerTest extends ResortTestCase
{


    private function prepForResortRequest()
    {
        $this->appApiTestToken();
        $this->createResort();
        $this->createResortProduct();
        ProductSpecialty::factory(['product_id' => $this->resortProduct->id, 'specialty_id' => Specialty::factory()->create()])
            ->count(3)
            ->create();
        $this->createProductAlbum();
        Photo::factory()->create();
        $this->createResortProductAttribute();
        $this->createSpecialtyProductAttribute();

        ProductImage::factory()->count(2)->create([
            'image_id' => Image::factory(),
            'show_in_gallery' => 1
        ]);
        ProductImage::factory()->create([
            'image_id' => Image::factory(),
            'show_in_gallery' => false
        ]);
    }

    /** @test */
    public function account_authed_can_access()
    {
        $this->apiTestToken();

        $this->getJson(route('mobile.resort.index'))->assertOk();
    }

    /** @test */
    public function app_authed_can_access()
    {
        $this->appApiTestToken();

        $this->getJson(route('mobile.resort.index'))->assertOk();
    }

    /** @test */
    public function not_open_to_public()
    {
        $this->withoutExceptionHandling()
            ->expectException(AuthenticationException::class);

        $response = $this->getJson(route('mobile.resort.index'));
    }

    /** @test */
    public function can_get_list_of_resorts()
    {
        $this->prepForResortRequest();

//        dd($this->resort->description);

        $response = $this->json('GET',
            route('mobile.resort.index'),
//            ['relations' => ['albums']]
        )->assertOk();

//        dd($response['resorts']['data'][0]);

        $this->assertEquals(1, count($response['resorts']['data']));
    }

    /** @test */
    public function can_get_a_single_resort()
    {
        $this->prepForResortRequest();

        $response = $this->json('GET',
            route('mobile.resort.show', $this->resort),
            ['relations' => [
                'albums',
                'albums.photos',
                'images',
                'fptManager',
                'airport',
                'country',
                'type',
                'specialties',
            ]]
        )->assertOk();

        $this->assertEquals($this->resort->id, $response['id']);
        $this->assertCount(3, $response['specialties']);
        $this->assertCount(2, $response['images']);
    }
}
