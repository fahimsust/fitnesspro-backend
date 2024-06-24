<?php

namespace Domain\Accounts\Actions\Membership;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Orders\Models\Order\Order;
use Illuminate\Support\Carbon;
use Support\Contracts\AbstractAction;

class RenewFromExistingMembership extends AbstractAction
{
    private Carbon $startDate;

    private Subscription $newMembership;

    public function __construct(
        public Order             $order,
        public Account           $account,
        public Subscription $oldMembership,
        public float             $paid,
    )
    {
    }

    public function result(): Subscription
    {
        return $this->newMembership;

    }

    public function execute(): static
    {
        $this->newMembership = Subscription::create([
                'amount_paid' => $this->paid,
                'start_date' => $this->getStartDate(),
                'end_date' => $this->startDate->copy()->addYear(),
                'order_id' => $this->order->id,
                'created' => now(),
            ] + $this->dataCopiedFromOldMembership());

        RecordMembershipReferral::run(
            $this->account,
            $this->newMembership,
        );

        if ($this->newMembership->level->auto_renew_reward > 0) {
            RewardLinkedAffiliateAccountForAutoRenewal::run(
                $this->account,
                $this->newMembership,
                $this->order
            );
        }

        return $this;
    }

    private function getStartDate(): Carbon
    {
        return $this->startDate = Carbon::createFromTimeString($this->oldMembership->end_date)
            ->addSecond();
    }

    private function dataCopiedFromOldMembership(): array
    {
        $data = [];

        foreach ([
                     'account_id',
                     'level_id',
                     'subscription_price',
                     'product_id',
                     'auto_renew',
                     'renew_payment_method',
                     'renew_payment_profile_id',
                 ] as $field)
            $data[$field] = $this->oldMembership->$field;

        return $data;
    }
}
