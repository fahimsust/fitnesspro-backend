<?php

namespace Tests\Feature\Traits;

use Database\Seeders\MessageTemplateSeeder;
use Database\Seeders\PaymentGatewaySeeder;
use Database\Seeders\PaymentMethodSeeder;
use Domain\Accounts\Models\AccountAddress;
use Domain\Accounts\Models\Membership\SubscriptionPaymentOption;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Orders\Actions\Cart\Item\AddItemToCartFromDto;
use Domain\Orders\Dtos\CartItemDto;
use Domain\Products\Models\Product\ProductDistributor;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\SiteMessageTemplate;
use Domain\Sites\Models\SiteSettings;

trait TestsRegistration
{
    protected Registration $registration;
    private SubscriptionPaymentOption $subscriptionPaymentOption;

    protected function createRegistrationReadyToPlaceOrder()
    {
        $this->seed([
            PaymentGatewaySeeder::class,
            PaymentMethodSeeder::class,
            MessageTemplateSeeder::class
        ]);

        $this->registration = Registration::factory()
            ->readyToPlaceOrder()
            ->create();

        $accountAddress = AccountAddress::factory()
            ->for($this->registration->account)
            ->create([
                'account_id' => $this->registration->account->id,
                'is_billing' => true,
                'is_shipping' => true,
                'status' => true
            ]);

        $this->registration->account
            ->update([
                'default_billing_id' => $accountAddress->id,
                'default_shipping_id' => $accountAddress->id,
            ]);

        $prodDist = ProductDistributor::factory()->create([
            'product_id' => $this->registration->level->product->id,
            'distributor_id' => $this->registration->level->product->default_distributor_id,
        ]);

        $this->createSubscriptionPaymentOptionUsingRegistration();
        SiteMessageTemplate::firstOrFactory();
        SiteSettings::firstOrFactory();
        ProductPricing::factory()
            ->for($this->registration->site)
            ->for($this->registration->level->product)
            ->create();

        $cartItem = AddItemToCartFromDto::now(
            cart: $this->registration->cart,
            cartItemDto: CartItemDto::fromRegistration($this->registration),
            checkAvailability: false,
            checkRequiredAccessories: false,
        );
    }

    protected function createSubscriptionPaymentOptionUsingRegistration(
        ?int $paymentAccountId = null
    ): SubscriptionPaymentOption
    {
        return $this->subscriptionPaymentOption = SubscriptionPaymentOption::firstOrFactory(array_filter([
            'site_id' => $this->registration->site_id,
            'payment_method_id' => $this->registration->payment_method_id,
            'gateway_account_id' => $paymentAccountId
        ], fn($value) => $value !== null));
    }
}
