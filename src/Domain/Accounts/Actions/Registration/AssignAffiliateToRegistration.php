<?php

namespace Domain\Accounts\Actions\Registration;

use App\Api\Accounts\Requests\Registration\AssignAffiliateToRegistrationRequest;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Affiliates\Models\Affiliate;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsObject;

class AssignAffiliateToRegistration
{
    use AsObject;

    private Affiliate $affiliate;

    public function handle(
        AssignAffiliateToRegistrationRequest $request,
        int                                  $registration_id
    ): Affiliate
    {
        $registration = Registration::findOrFail($registration_id);

        $errors = [];
        if ($registration->affiliate_id !== null) {
            $errors['affiliate_id'] = __('Affiliate already set');
        }
        if (count($errors) > 0) {
            throw ValidationException::withMessages($errors);
        }
        // if ($registration->affiliate_id !== null) {
        //     throw new \Exception(__('Affiliate already set'));
        // }

        $registration->update([
            'affiliate_id' => $this->loadAffiliate($request)->id,
        ]);

        return $this->affiliate;
    }

    private function loadAffiliate(AssignAffiliateToRegistrationRequest $request)
    {
        return $this->affiliate = Affiliate::findOrFail($request->affiliate_id);
    }
}
