<?php

namespace Domain\Accounts\Actions\Membership;

use Domain\Accounts\Actions\Membership\Levels\GetAvailableLevels;
use Domain\Accounts\Actions\Registration\LoadRegistrationById;
use Domain\Accounts\Actions\Registration\Order\Cart\StartCartFromRegistration;
use Domain\Accounts\Actions\Registration\Order\Cart\UpdateCartFromRegistration;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Orders\Models\Carts\Cart;
use Support\Contracts\AbstractAction;

class SetRegistrationMembershipLevel extends AbstractAction
{
    public MembershipLevel $membershipLevel;
    public Registration $registration;
    public bool $updated = false;
    public bool $createdCart = false;
    public bool $updatedCart = false;

    public function __construct(
        public int  $membershipLevelId,
        public int  $registrationId,
        public bool $updateCart = true
    )
    {
    }

    public function result(): MembershipLevel
    {
        return $this->membershipLevel;
    }

    public function execute(): static
    {
        if ($this->loadMembershipLevel()->status !== true) {
            throw new \Exception(__('Inactive membership level'));
        }

        $this->registration = LoadRegistrationById::now($this->registrationId);
        $this->registration->level_id = $this->membershipLevelId;

        if ($this->registration->isDirty('level_id')) {
            $this->createUpdateCart();

            $this->registration->save();
            $this->registration->clearCaches();

            $this->updated = true;
        }

        return $this;
    }

    protected function loadMembershipLevel(): MembershipLevel
    {
        return $this->membershipLevel = GetAvailableLevels::now(
            onlyActiveLevels: false,
            membershipLevelId: $this->membershipLevelId
        );
    }

    protected function createUpdateCart(): ?Cart
    {
        if (!$this->updateCart) {
            return null;
        }

        if ($this->registration->cart_id > 0) {
            $this->updatedCart = true;

            return UpdateCartFromRegistration::now(
                $this->registration
            );
        }

        $this->createdCart = true;

        return StartCartFromRegistration::now($this->registration);
    }
}
