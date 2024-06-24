<?php

namespace Domain\Accounts\Actions\Signup;

use Domain\Accounts\Models\Registration\Registration;
use Domain\Discounts\Actions\FindDiscountByCode;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class ApplyDiscountCodeToRegistration
{
    use AsObject;

    public function handle(Registration $registration, string $discountCode): Collection
    {
        $discount = $this->findDiscount($discountCode);

        if ($registration->discounts()->whereId($discount->id)->count()) {
            throw new \Exception(__('Discount has already been applied to registration'));
        }

        //todo check which advantages should apply based on other rules/conditions

        return $registration->discounts()
            ->createMany(
                $discount->advantages()
                    ->get()
                    ->map(
                        fn (DiscountAdvantage $advantage) => [
                            'discount_id' => $discount->id,
                            'advantage_id' => $advantage->id,
                            'amount' => $advantage->amount,
                        ]
                    )
            );
    }

    private function findDiscount(string $discountCode): Discount
    {
        return FindDiscountByCode::run($discountCode);
    }
}
