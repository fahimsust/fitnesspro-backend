<?php

namespace Domain\Orders\Actions\Checkout;

use Domain\Accounts\Actions\LoadAccountByIdFromCache;
use Domain\Accounts\Models\Account;
use Domain\Orders\Enums\Checkout\CheckoutStatuses;
use Domain\Orders\Exceptions\AccountNotAllowedCheckoutException;
use Domain\Orders\Exceptions\CartNotAllowedCheckoutException;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Checkout\Checkout;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Model;
use Support\Contracts\AbstractAction;

class FindCreateCheckout extends AbstractAction
{
    public function __construct(
        public Cart $cart,
        public Account  $account,
        public ?int $affiliateId = null,
    )
    {
    }

    public function execute(): Checkout
    {
        CartNotAllowedCheckoutException::check($this->cart);
        AccountNotAllowedCheckoutException::check($this->account);

        return $this->findCheckout()
            ?? $this->createCheckout();
    }

    protected function site(): Site
    {
        return $this->cart->siteCached();
    }

    protected function findCheckout(): Checkout|Model|null
    {
        return $this->site()
            ->checkouts()
            ->where('cart_id', $this->cart->id)
            ->where('account_id', $this->account->id)
            ->where('affiliate_id', $this->affiliateId)
            ->where(
                'status',
                '!=',
                CheckoutStatuses::Completed
            )
            ->first();
    }

    protected function createCheckout(): Checkout|Model
    {
        return $this->site()->checkouts()->create(
            [
                'cart_id' => $this->cart->id,
                'account_id' => $this->account->id,
                'affiliate_id' => $this->affiliateId,
                'status' => CheckoutStatuses::Init,
            ]
        );
    }
}
