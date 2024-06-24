<?php

namespace App\Api\Orders\Requests\Checkout;

use Domain\Orders\Actions\Checkout\LoadCheckoutByUuid;
use Domain\Orders\Exceptions\CheckoutAlreadyCompletedException;
use Domain\Orders\Models\Checkout\Checkout;
use Illuminate\Foundation\Http\FormRequest;
use Worksome\RequestFactories\Concerns\HasFactory;

abstract class AbstractCheckoutRequest extends FormRequest
{
    use HasFactory;

    private Checkout $checkout;

    public function authorize()
    {
        return true;
    }

    protected function validateCheckoutStatus(): void
    {
        CheckoutAlreadyCompletedException::check(
            $this->loadCheckoutByUuid()
        );
    }

    protected function prepareForValidation()
    {
        if (!$this->route('checkout_uuid')) {
            return;
        }

        $this->merge([
            'checkout_uuid' => $this->route('checkout_uuid'),
        ]);
    }

    public function rules()
    {
        return [
            'checkout_uuid' => ['required', 'string'],
        ];
    }

    public function loadCheckoutByUuid(): Checkout
    {
        return $this->checkout
            ??= LoadCheckoutByUuid::now($this->checkout_uuid);
    }
}
