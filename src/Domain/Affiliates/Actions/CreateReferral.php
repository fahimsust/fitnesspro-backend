<?php

namespace Domain\Affiliates\Actions;


use Domain\Affiliates\Enums\ReferralType;
use Domain\Affiliates\Models\Affiliate;
use Domain\Affiliates\Models\Referral;
use Illuminate\Database\Eloquent\Model;
use Support\Contracts\AbstractAction;

class CreateReferral extends AbstractAction
{
    public function __construct(
        public Affiliate    $affiliate,
        public ?int          $orderId,
        public ReferralType $referralType,
        public float        $amount,
    )
    {
    }

    public function execute(): Referral|Model
    {
        return $this->affiliate
            ->referrals()
            ->create([
                'order_id' => $this->orderId,
                'status_id' => 1,
                'amount' => $this->amount,
                'type_id' => $this->referralType
            ]);
    }
}
