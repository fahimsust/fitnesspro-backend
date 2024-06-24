<?php

namespace Domain\Orders\Dtos;

use Domain\Accounts\Models\Account;
use Domain\Addresses\Models\Address;
use Domain\Orders\Actions\Order\GenerateOrderNumber;
use Domain\Orders\Enums\Order\OrderStatuses;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Checkout\Checkout;
use Domain\Payments\Models\PaymentMethod;
use Domain\Sites\Models\Site;
use Spatie\LaravelData\Data;

class OrderDto extends Data
{
    public function __construct(
        public PaymentMethod $paymentMethod,
        public Site          $site,

        public ?string       $orderNo = null,

        public ?string       $comments = null,

        public ?string       $phone = null,
        public ?string       $email = null,

        public ?float         $paymentMethodFee = 0,

        public ?Account      $account = null,
        public ?Cart         $cart = null,

        public ?Address      $billingAddress = null,
        public ?Address      $shippingAddress = null,
    )
    {
        if (!$this->orderNo) {
            $this->orderNo = GenerateOrderNumber::now();
        }

        if ($this->account) {
            $this->billingAddress ??= $this->account->loadMissing('defaultBillingAddress')->defaultBillingAddress;
            $this->shippingAddress ??= $this->account->loadMissing('defaultShippingAddress')->defaultShippingAddress;

            $this->phone ??= $this->account->phone;
            $this->email ??= $this->account->email;
        }
    }

    public static function usingBasics(
        string        $orderNo,
        PaymentMethod $paymentMethod,
        Site          $site,
    ): static
    {
        return self::from([
            'orderNo' => $orderNo,
            'paymentMethod' => $paymentMethod,
            'site' => $site,
        ]);
    }

    public static function fromCartModel(
        Cart          $cart,
        PaymentMethod $paymentMethod
    ): static
    {
        return new static(
            paymentMethod: $paymentMethod,
            site: $cart->siteCached(),
            account: $cart->account,
            cart: $cart,
        );
    }

    public static function fromCheckoutModel(
        Checkout $checkout,
    ): static
    {
        return new static(
            paymentMethod: $checkout->paymentMethodCached(),
            site: $checkout->siteCached(),
            comments: $checkout->comments,
            paymentMethodFee: $checkout->paymentMethodCached()?->fee,
            account: $checkout->accountCached(),
            cart: $checkout->cartCached(),
            billingAddress: $checkout->billingAddressCached(),
            shippingAddress: $checkout->shippingAddressCached(),
        );
    }

    public function toModel(): array
    {
        return [
            'order_no' => $this->orderNo,
            'account_id' => $this->account?->id,

            'billing_address_id' => $this->billingAddress?->id,
            'shipping_address_id' => $this->shippingAddress?->id,

            'order_phone' => $this->phone,
            'order_email' => $this->email,

            'payment_method' => $this->paymentMethod?->id,
            'payment_method_fee' => $this->paymentMethodFee,

            'comments' => $this->comments,
            'site_id' => $this->site->id,
            'cart_id' => $this->cart->id,

            'status' => OrderStatuses::Recorded,
        ];
    }
}
