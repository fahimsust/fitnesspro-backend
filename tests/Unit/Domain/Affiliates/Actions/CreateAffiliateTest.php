<?php

namespace Tests\Unit\Domain\Affiliates\Actions;

use App\Api\Admin\Affiliates\Requests\CreateAffiliateRequest;
use Domain\Affiliates\Actions\CreateAffiliate;
use Domain\Affiliates\Models\Affiliate;
use Tests\TestCase;


class CreateAffiliateTest extends TestCase
{

    /** @test */
    public function can_create_affiliate()
    {
        $affiliateRequest = $this->postRequestFactory(
            CreateAffiliateRequest::class
        );

        $affiliate = CreateAffiliate::run($affiliateRequest);

        $this->assertInstanceOf(Affiliate::class, $affiliate);
        $this->assertModelExists($affiliate);
        $this->assertEquals(1, Affiliate::count());
    }
}
