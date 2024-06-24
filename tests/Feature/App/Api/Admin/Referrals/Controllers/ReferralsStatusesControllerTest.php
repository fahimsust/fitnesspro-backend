<?php

namespace Tests\Feature\App\Api\Admin\Referrals\Controllers;

use Domain\Affiliates\Models\ReferralStatus;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ReferralsStatusesControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
    }


    /** @test */
    public function can_get_all_the_referral_status()
    {
        ReferralStatus::factory(3)->create();
        $this->getJson(route('admin.referrals-statuses.list'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name'
                ]
            ])->assertJsonCount(3);
    }


    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->getJson(route('admin.referrals-statuses.list'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
