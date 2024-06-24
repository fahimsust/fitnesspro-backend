<?php

namespace Domain\Orders\Actions\Order\Discount;

use Domain\Accounts\Models\Account;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Models\Order\Order;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;

class ApplyDiscountToOrder extends AbstractAction
{
    private Collection $appliedAdvantages;

    public function __construct(
        public Order    $order,
        public Discount $discount,
        public ?Account $account = null,
    )
    {
        if (!$this->account) {
            $this->account = $this->order->loadMissing('account')->account;
        }

        $this->appliedAdvantages = collect();
    }

    public function execute(): void
    {
        $this->discount->advantages
            ->whenEmpty(
                fn() => throw new \Exception(__('No advantages found for discount'))
            )
            ->each(
                function (DiscountAdvantage $advantage) {
                    $applied = ApplyDiscountAdvantageToOrder::run(
                        order: $this->order,
                        advantage: $advantage,
                        account: $this->account,
                    )
                        ->logActivity()
                        ->result();

                    if (!$applied) {
                        return;
                    }

                    $this->appliedAdvantages->push($applied);
                }
            );
            if(count($this->appliedAdvantages) == 0)
            {
                throw new \Exception(__('No advantages found for discount that can be apply to order'));
            }
            if ($this->account && count($this->appliedAdvantages) > 0) {
                AddAccountUsedDiscount::now(
                    discount: $this->discount,
                    orderId: $this->order->id,
                    accountId: $this->account?->id,
                );
            }
    }
}
