<?php

namespace Domain\Accounts\Actions\Registration;

use App\Api\Accounts\Requests\Registration\RemoveDiscountFromRegistrationRequest;
use Domain\Accounts\Models\Registration\RegistrationDiscount;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

//todo remove
class RemoveDiscountFromRegistration
{
    use AsObject;

    public function handle(RemoveDiscountFromRegistrationRequest $request,int $registration_id): Collection
    {
        $registrationDiscount = RegistrationDiscount::findOrFail($request->registration_discount_id);

        if ($registrationDiscount->registration_id !== $registration_id) {
            throw new \Exception(__('Invalid Request'));
        }

        $registrationDiscount->delete();

        return RegistrationDiscount::whereRegistrationId($registration_id)->get();
    }
}
