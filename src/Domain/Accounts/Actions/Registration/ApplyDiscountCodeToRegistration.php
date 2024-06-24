<?php

namespace Domain\Accounts\Actions\Registration;

use Domain\Accounts\Models\Registration\Registration;
use Domain\Discounts\Actions\AbstractApplyDiscountCodeAction;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Validation\ValidationException;

//todo remove
class ApplyDiscountCodeToRegistration extends AbstractApplyDiscountCodeAction
{
    use AsObject;

    public function handle(Registration $registration, string $discountCode): Collection
    {
        $discount = $this->findDiscount($discountCode);

        $errors = [];
        if ($registration->discounts()->whereId($discount->id)->count()) {
            $errors['discount_code'] = __('Discount has already been applied to registration');
            //throw new \Exception(__('Discount has already been applied to registration'));
        }
        if (count($errors) > 0) {
            throw ValidationException::withMessages($errors);
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
}
