<?php

namespace Tests\Feature\App\Api\Accounts\Controllers;

use Carbon\Carbon;
use Database\Seeders\AccountStatusSeeder;
use Database\Seeders\AccountTypeSeeder;
use Database\Seeders\CountryRegionSeeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\StateSeeder;
use Domain\Accounts\Models\AccountAddress;
use Domain\Accounts\Models\AccountSpecialty;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Accounts\Models\Specialty;
use Domain\Photos\Models\Photo;
use Illuminate\Validation\ValidationException;
use function route;
use Tests\Feature\Traits\HasTestAccount;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    use HasTestAccount;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private $activeMembership;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private $profilePhoto;

    private $billingAddress;

    private $shippingAddress;

    private \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model $specialties;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            CountrySeeder::class,
            CountryRegionSeeder::class,
            StateSeeder::class,
            AccountStatusSeeder::class,
            AccountTypeSeeder::class,
        ]);

        $this->apiTestToken();

        $this->profilePhoto = Photo::factory()->create();
        $this->billingAddress = AccountAddress::factory()->create();
        $this->shippingAddress = AccountAddress::factory()->create();

        $this->seedAccountCellphoneField();

        $this->account->update([
            'status_id' => 1,
            'photo_id' => $this->profilePhoto->id,
            'default_billing_id' => $this->billingAddress->id,
            'default_shipping_id' => $this->shippingAddress->id,
        ]);

        $startDate = (new Carbon('2 year ago'))->toDateTimeString();
        $endDate = (new Carbon('1 year ago'))->toDateTimeString();

        $inactiveMembership = Subscription::factory()->create([
            'account_id' => $this->account->id,
            'status' => 0,
            'created' => $startDate,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        $this->activeMembership = Subscription::factory()->create([
            'account_id' => $this->account->id,
        ]);

        $this->specialties = Specialty::factory()->count(5)->create();
        $this->specialties
            ->skip(1)
            ->first(
                fn ($specialty) => AccountSpecialty::factory()->create([
                    'account_id' => $this->account->id,
                    'specialty_id' => $specialty->id,
                    'approved' => 0,
                ])
            );
        $this->specialties
            ->skip(2)
            ->each(
                fn ($specialty) => AccountSpecialty::factory()->create([
                    'account_id' => $this->account->id,
                    'specialty_id' => $specialty->id,
                    'approved' => 1,
                ])
            );
    }

    /** @test */
    public function can_access_non_account_specific_endpoints()
    {
        $this->apiTestToken(); //create/login this->account

        $this->withoutExceptionHandling()
            ->expectException(ValidationException::class);

        $this->postJson(route('mobile.support.store'));
    }

    /** @test */
    public function can_only_access_account_authed()
    {
        $secondaryAccount = $this->createAndAuthAccount();

        $this->getJson(route('mobile.account.show', $this->account->id))
            ->assertOk(); //authed account

//        $this->expectException(AuthenticationException::class);//"Account does not match token");

        $this->getJson(route('mobile.account.show', $secondaryAccount->id))
            ->assertUnauthorized(); //not authed account
    }

    /** @test */
    public function can_get_account_details()
    {
//        $this->withExceptionHandling();
        $response = $this->getJson(
            route('mobile.account.show', $this->account->id)
        )
            ->assertOk();

        $account = $response['account'];
//        dd($account);

        $this->assertEquals($this->account->id, $account['id']);

        //contact info
        $this->assertNotNull($account['fullname']);
        $this->assertNotNull($account['user']);
        $this->assertNotNull($account['email']);
        $this->assertNotNull($account['phone']);

        //default billing
        $this->assertNotNull($account['default_billing_address']);

        //default shipping
        $this->assertNotNull($account['default_shipping_address']);

        //status
        $this->assertEquals(1, $account['status_id']);
        $this->assertNotNull($account['status']);

        //type
        $this->assertEquals(1, $account['type_id']);
        $this->assertNotNull($account['type']);

        //profile photo
        $this->assertEquals($this->profilePhoto->id, $account['profile_photo']['id']);
        $this->assertNotNull($account['profile_photo']['url']);

        //membership
        $this->assertNotNull($account['active_membership']);
        $this->assertEquals($this->activeMembership->id, $account['active_membership']['id']);

        //specialties
        $this->assertIsArray($account['approved_specialties']);
        $this->assertCount(3, $account['approved_specialties']);
    }
}
