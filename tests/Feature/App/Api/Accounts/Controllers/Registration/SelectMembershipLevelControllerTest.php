<?php

namespace Tests\Feature\App\Api\Accounts\Controllers\Registration;

use Domain\Accounts\Actions\Membership\SetRegistrationMembershipLevel;
use Domain\Accounts\Exceptions\RegistrationNotFoundException;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteSettings;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;
use function route;


class SelectMembershipLevelControllerTest extends TestCase
{
    public Registration $registration;

    private Collection $levels;
    private array $levelStructure;

    protected function setUp(): void
    {
        parent::setUp();

        $product = Product::factory()->create();
        ProductPricing::factory()->create([
            'price_reg' => 10.00,
            'product_id' => $product->id,
            'site_id' => $site = Site::firstOrFactory()
        ]);

        Config::set('site.id', $site->id);
        SiteSettings::factory()
            ->for($site)
            ->create();

        $this->registration = Registration::factory()->create();

        $this->levels = MembershipLevel::factory(5)->create();

        $this->levels->first()->update([
            'annual_product_id' => $product->id,
        ]);

        $this->levelStructure = [
            'id',
            'name',
            'rank',
            'annual_product_id',
            'monthly_product_id',
            'renewal_discount',
            'description',
            'signupemail_customer',
            'renewemail_customer',
            'expirationalert1_email',
            'expirationalert2_email',
            'expiration_email',
            'affiliate_level_id',
            'is_default',
            'signuprenew_option',
            'product',
        ];
        session(['registrationId' => $this->registration->id]);
    }

    /** @test */
    public function can_get_member_levels()
    {
//        $site = Site::first();
//        Config::set('site.id', $site->id);
//        ProductPricing::factory()->create([
//            'product_id' => $this->levels->first()->annual_product_id,
//            'site_id' => $site->id,
//        ]);

        $response = $this->getJson(route('registration.level.view'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(5, 'levels')
            ->assertJsonStructure(
                [
                    'levels' => [ '*' => $this->levelStructure ],
                    'selected_level'
                ]
            );

//        dd($response->json());
    }

    /** @test */
    public function can_select_membership_level_and_create_cart()
    {
        $this->assertDatabaseCount(Cart::class, 0);

        $this->postJson(
            route('registration.level.store'),
            [
                'level_id' => $this->levels->first()->id,
            ]
        )
            ->assertCreated()
            ->assertJsonStructure(
                $this->levelStructure
            );

        $this->assertEquals($this->levels->first()->id, $this->registration->fresh()->level_id);
        $this->assertDatabaseCount(Cart::class, 1);
    }

    /** @test */
    public function can_select_membership_level_and_update_cart()
    {
        $cart = Cart::factory(['is_registration' => true])->create();
        $this->registration->update([
            'cart_id' => CartItem::factory(2)
                ->for($cart)
                ->create()
                ->first()
                ->cart_id
        ]);

        $this->assertDatabaseCount(CartItem::class, 2);
        $this->assertDatabaseCount(Cart::class, 1);

        $this->postJson(
            route('registration.level.store'),
            [
                'level_id' => $this->levels->first()->id,
            ]
        )
            ->assertCreated()
            ->assertJsonStructure(
                $this->levelStructure
            );

        $this->assertEquals($this->levels->first()->id, $this->registration->fresh()->level_id);
        $this->assertDatabaseCount(Cart::class, 1);
        $this->assertDatabaseCount(CartItem::class, 1);
    }

    /** @test */
    public function can_return_selected_membership_level()
    {
        $this->registration->update([
            'level_id' => $this->levels->first()->id
        ]);

        $this->getJson(route('registration.level.show'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                $this->levelStructure
            );
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('registration.level.store'), ['level_id' => 0])
            ->assertJsonValidationErrorFor('level_id')
            ->assertStatus(422);

        $this->assertNotEquals($this->levels->first()->id, Registration::first()->level_id);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->registration->delete();

        $this->postJson(route('registration.level.store'), ['level_id' => $this->levels->first()->id])
            ->assertStatus(404)
            ->assertJsonFragment(['exception' => RegistrationNotFoundException::class,]);

        $this->assertNotEquals($this->levels->first()->id, $this->registration->level_id);
    }
}
