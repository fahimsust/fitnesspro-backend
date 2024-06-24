<?php

namespace Domain\Orders\Actions\Cart;

use App\Api\Orders\Exceptions\Cart\CartMissingFromSession;
use Domain\Accounts\Models\Account;
use Domain\Orders\Exceptions\CartNotFoundException;
use Domain\Orders\Models\Carts\Cart;
use Illuminate\Http\Request;
use Support\Contracts\AbstractAction;

class GetCartFromSession extends AbstractAction
{
    public function __construct(
        private ?Account $account = null,
    )
    {
    }


    public function execute(): Cart
    {
        return session()->has('cart')
            ? $this->loadCart()
            : StartCart::now(account: $this->account);
    }

    public static function throwIfMissing(?Account $account = null): Cart
    {
        if (!session()->has('cart')) {
            throw new CartMissingFromSession();
        }

        return static::now(account: $account);
    }

    public static function fromRequest(Request $request): Cart
    {
        return static::now(account: $request->user('web'));
    }

    private function loadCart(): Cart
    {
        $cart = Cart::find(session('cart')['id'])
            ?? throw new CartNotFoundException();

        (new ConfirmCartOwnerMatchesUser($cart, $this->account))
            ->throwOnFailure();

        return $cart;
    }
}
