<?php

namespace Tests\Feature\App\Api\Accounts\Controllers\Registration;

use Domain\Accounts\Actions\Registration\ApplyDiscountCodeToRegistration;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Accounts\Models\Registration\RegistrationDiscount;
use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Discounts\Models\Rule\Condition\DiscountConditionType;
use Domain\Discounts\Models\Rule\DiscountRule;
use Domain\Orders\Actions\Cart\Discounts\ApplyDiscountCodeToCart;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountAdvantage;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Tests\TestCase;
use function route;


class RegistrationDiscountControllerTest extends TestCase
{
    public Registration $registration;
    private array $registrationStructure;
    private Collection $discounts;
    private \Illuminate\Database\Eloquent\Collection $registrationDiscounts;

    protected function setUp(): void
    {
        parent::setUp();

        $this->registration = Registration::factory([
            'cart_id' => Cart::factory()
        ])->create();

        $this->discounts = Discount::factory(5)->create()
            ->each(
                function (Discount $discount) {
                    DiscountCondition::factory()->create([
                        'condition_type_id' => DiscountConditionTypes::REQUIRED_DISCOUNT_CODE,
                        'rule_id' => DiscountRule::factory(['discount_id' => $discount->id])
                    ]);
                    DiscountAdvantage::factory()->create([
                        'discount_id' => $discount->id
                    ]);
                }
            );

        $this->registrationStructure = [
            'id',
            'cart_id',
            'discount_id',
            'discount',
            'advantages' => [
                '*' => [
                    'advantage_id',
                    'amount'
                ]
            ]
        ];
        session(['registrationId' => $this->registration->id]);
    }

    /** @test */
    public function can_get_registration_discounts()
    {
        $this->createRegistrationDiscounts();

        $this->getJson(route('registration.discount.view'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(6)
            ->assertJsonStructure(
                [
                    '*' => $this->registrationStructure
                ]
            );
    }

    /** @todo */
    public function can_store_register_discont()
    {
        $this->postJson(
            route('registration.discount.store'),
            [
                'discount_code' => $this->getFirstDiscountCode(),
            ]
        )
            ->assertCreated()
            ->assertJsonStructure([
                '*' => $this->registrationStructure
            ]);

        $this->assertDatabaseCount(CartDiscount::Table(), 1);
        $this->assertEquals($this->discounts->first()->id, CartDiscount::first()->discount_id);
    }

    /** @test */
    public function can_remove_registration()
    {
        $this->createRegistrationDiscounts();

        $this->deleteJson(route('registration.discount.delete'), [
            'registration_discount_id' => $this->registrationDiscounts->first()->cart_discount_id
        ])
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseCount(CartDiscount::Table(), 5);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(
            route('registration.discount.store')
        )
            ->assertJsonValidationErrorFor('discount_code')
            ->assertStatus(422);

        $this->assertDatabaseCount(CartDiscount::Table(), 0);
    }

    /** @todo */
    public function can_handle_errors()
    {
        $this->partialMock(ApplyDiscountCodeToCart::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(
            route('registration.discount.store'),
            [
                'discount_code' => $this->getFirstDiscountCode(),
            ]
        )
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(CartDiscount::Table(), 0);
    }

    private function createRegistrationDiscounts(): void
    {
        $this->registrationDiscounts = CartDiscountAdvantage::factory()
            ->createMany(
                $this->discounts->map(
                    fn(Discount $discount) => [
                        'cart_discount_id' => CartDiscount::factory([
                            'discount_id' => $discount->id
                        ])->for($this->registration->cart),
                        'advantage_id' => $discount->advantages->first()->id,
                        'amount' => $discount->advantages->first()->amount,
                    ])
            );
    }

    private function getFirstDiscountCode(): string
    {
        return $this->discounts->first()->load('rules.conditions')
            ->rules->first()
            ->conditions->first()
            ->required_code;
    }
}
