<?php

namespace App\Api\Orders\Requests\Checkout;

use App\Api\Orders\Traits\RequestCanReturnCheckoutResource;
use Domain\Accounts\Actions\LoadAccountByIdFromCache;
use Domain\Accounts\Models\Account;
use Domain\Orders\Actions\Cart\LoadCartById;
use Domain\Orders\Exceptions\AccountNotAllowedCheckoutException;
use Domain\Orders\Exceptions\CartNotAllowedCheckoutException;
use Domain\Orders\Exceptions\CartNotFoundException;
use Domain\Orders\Models\Carts\Cart;
use Illuminate\Foundation\Http\FormRequest;
use Worksome\RequestFactories\Concerns\HasFactory;

class StartCheckoutRequest extends FormRequest
{
    use HasFactory,
        RequestCanReturnCheckoutResource;

    public Cart $cart;
    public Account $account;

    public function authorize()
    {
        $this->cart = LoadCartById::now($this->cart_id);

        CartNotAllowedCheckoutException::check($this->cart);

        $this->account = LoadAccountByIdFromCache::now($this->account_id);

        AccountNotAllowedCheckoutException::check(
            $this->account,
        );

        return $this->cart->account_id === $this->account->id
            || $this->cart->account_id == null;
    }

    public function rules()
    {
        return [
            'cart_id' => ['required', 'integer', 'gt:0'],
            'account_id' => ['required', 'integer', 'gt:0'],
        ];
    }
}
