<?php

namespace Domain\Accounts\Actions\Registration;

use Domain\Accounts\Exceptions\RegistrationNotFoundException;
use Domain\Accounts\Models\Registration\Registration;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadRegistrationInFull extends AbstractAction
{
    private Registration $registration;

    public function __construct(
        public int  $registrationId,
        public bool $useCache = true,
    )
    {
    }

    public function execute(): Registration
    {
        $this->registration = $this->loadRegistration();

        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::tags([
            "account-cache.{$this->registration->account_id}",
            "affiliate-cache.{$this->registration->affiliate_id}",
            "membership-level-cache.{$this->registration->level_id}",
            "product-cache.{$this->registration->product_id}",
            "payment-method-cache.{$this->registration->payment_method_id}",
            "registration-cache.{$this->registrationId}",
            "cart-registration-cache.{$this->registration->id}",
            "cart-cache.{$this->registration->cart_id}",
        ])
            ->remember(
                'load-registration-full.' . $this->registrationId,
                60 * 5,
                fn() => $this->load()
            );
    }

    protected function load(): Registration
    {
        $registration = $this->registration->loadMissing([
            'account',
            'affiliate',
            'levelWithProduct',
            'paymentMethod',
            'cart'
        ]);

        if (!$registration) {
            throw new RegistrationNotFoundException(
                __("Registration with id {$this->registrationId} not found.")
            );
        }

        // Check if the account relation was loaded and make username visible
        if ($registration->relationLoaded('account') && $registration->account) {
            $registration->account->makeVisible('username');
        }

        return $registration;
    }


    protected function loadRegistration(): Registration
    {
        if ($this->useCache) {
            return LoadRegistrationById::now(
                $this->registrationId,
            );
        }

        return Registration::find($this->registrationId)
            ?? throw new RegistrationNotFoundException(
                __("Registration with id {$this->registrationId} not found.")
            );
    }
}
