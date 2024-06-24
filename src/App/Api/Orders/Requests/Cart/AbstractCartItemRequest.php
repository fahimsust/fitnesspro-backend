<?php

namespace App\Api\Orders\Requests\Cart;

use App\Api\Orders\Traits\ConfirmsCartOwner;
use Illuminate\Foundation\Http\FormRequest;
use Worksome\RequestFactories\Concerns\HasFactory;

class AbstractCartItemRequest extends FormRequest
{
    use HasFactory,
        ConfirmsCartOwner;

    public function authorize()
    {
        return $this->confirmCartOwner($this)
            && $this->itemIsInCart($this->route('item') ?? $this->cart_item_id);
    }

    public function rules()
    {
        if ($this->route('item')) {
            return [];
        }

        return [
            'cart_item_id' => ['required', 'int'],
        ];
    }
}
