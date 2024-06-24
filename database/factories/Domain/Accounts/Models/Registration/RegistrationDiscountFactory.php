<?php

namespace Database\Factories\Domain\Accounts\Models\Registration;

use Illuminate\Database\Eloquent\Factories\Factory;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Accounts\Models\Registration\RegistrationDiscount;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;

//todo remove
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class RegistrationDiscountFactory extends Factory
{
    protected $model = RegistrationDiscount::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $discount = Discount::firstOrFactory();
        $advantage = DiscountAdvantage::factory()->create(['discount_id'=>$discount->id]);

        return [
            'registration_id' => Registration::firstOrFactory(),
            'discount_id' => $discount->id,
            'advantage_id'=> $advantage->id,
            'amount'=> $advantage->amount,
        ];
    }
}
