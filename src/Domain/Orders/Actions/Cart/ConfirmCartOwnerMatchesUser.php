<?php

namespace Domain\Orders\Actions\Cart;

use App\Api\Orders\Exceptions\Cart\CartDoesNotMatchAccount;
use Domain\Accounts\Models\Account;
use Domain\Orders\Models\Carts\Cart;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsObject;

class ConfirmCartOwnerMatchesUser
{
    use AsObject;

    public function __construct(
        public Cart $cart,
        public ?Account $account = null
    ) {
    }

    public static function fromRequest(
        Cart $cart,
        Request $request
    ): static {
        return new static($cart, $request->user('web'));
    }

    public function throwOnFailure(): void
    {
        if (! $this->handle()) {
            throw new CartDoesNotMatchAccount();
        }
    }

    public function handle(): bool
    {
        if (is_null($this->cart->account_id)) { //no account assigned to cart
            return true;
        }

        return $this->cart->account_id === $this->account?->id;
    }
}
