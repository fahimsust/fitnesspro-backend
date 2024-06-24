<?php

namespace Domain\Accounts\Jobs\Membership;

use App\Api\Payments\Requests\CimPaymentProfileRequest;
use Domain\Accounts\Actions\Membership\CheckIfFutureMembershipExists;
use Domain\Accounts\Actions\Membership\RenewFromExistingMembership;
use Domain\Accounts\Actions\Membership\ValidateAccountReadyForAutoRenewal;
use Domain\Accounts\Mail\MembershipAutoRenewalFailed;
use Domain\Accounts\Mail\MembershipHasBeenAutoRenewed;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Cim\CimPaymentProfile;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Orders\Actions\Cart\StartCart;
use Domain\Orders\Actions\Order\CompleteOrder;
use Domain\Orders\Actions\Order\CreateOrderWithDto;
use Domain\Orders\Actions\Order\PayOrderUsingPaymentRequest;
use Domain\Orders\Collections\OrderShipmentDtosCollection;
use Domain\Orders\Dtos\OrderDto;
use Domain\Orders\Dtos\OrderItemDto;
use Domain\Orders\Dtos\OrderPackageDto;
use Domain\Orders\Dtos\OrderShipmentDto;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Actions\LoadSiteSubscriptionPaymentAccountFromMethod;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Domain\Payments\Services\AuthorizeNet\DataObjects\TransactionDO;
use Domain\Sites\Models\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Support\Dtos\RedirectUrl;

class AutoRenewMembership implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected CimPaymentProfile $paymentProfile;
    private PaymentMethod $paymentMethod;
    private Site $site;
    private Subscription $activeMembership;
    private Order $order;
    private TransactionDO $authnetTransaction;
    private OrderTransaction $orderTransaction;
    private float $amount;
    private PaymentAccount $paymentAccount;
    private Subscription $newMembership;

    public int $tries = 1;
    private OrderTransaction|RedirectUrl|true $paymentResult;

    public function __construct(public Account $account)
    {
        $this->activeMembership = $this->account
            ->load(['activeMembership' => ['renewPaymentMethod', 'product']])
            ->activeMembership;
        $this->paymentMethod = $this->activeMembership->renewPaymentMethod;
        $this->site = Site::Init();
        $this->amount = $this->activeMembership->subscription_price;
    }

    public function handle()
    {
        DB::beginTransaction();

        if (CheckIfFutureMembershipExists::now($this->account))
            throw new \Exception("Future membership already exists for account");

        $this->paymentAccount = LoadSiteSubscriptionPaymentAccountFromMethod::now(
            $this->site,
            $this->paymentMethod
        );

        try {
            ValidateAccountReadyForAutoRenewal::run($this->account, false, 0);

            $this->createOrder()
                ->makePayment();
        } catch (\Throwable $exception) {
            //            dd($exception);
            DB::rollBack();

            Site::SendMailable(
                (new MembershipAutoRenewalFailed($this->account))
                    ->membership($this->activeMembership)
                    ->exception($exception)
            );

            throw $exception;
        }

        DB::commit();

        $this->createMembership()
            ->completeOrder();
    }

    protected function createOrder(): static
    {
        $this->order = CreateOrderWithDto::now(
            OrderDto::fromCartModel(
                cart: StartCart::now(
                    site: $this->site,
                    account: $this->account
                ),
                paymentMethod: $this->paymentMethod,
            )
        );

        return $this;
    }

    protected function makePayment(): static
    {
        $this->paymentResult = PayOrderUsingPaymentRequest::now(
            order: $this->order,
            request: new CimPaymentProfileRequest([
                'payment_profile_id' => $this->activeMembership->renew_payment_profile_id
            ]),
            account: $this->paymentAccount,
            method: $this->paymentMethod,
            amount: $this->amount
        );

        return $this;
    }

    protected function createMembership(): static
    {
        $this->newMembership = RenewFromExistingMembership::now(
            $this->order,
            $this->account,
            $this->activeMembership,
            $this->amount
        );

        return $this;
    }

    protected function completeOrder(): static
    {
        $itemDto = OrderItemDto::usingProduct(
            $this->activeMembership->product
        );
        $itemDto->priceReg = $this->amount;

        (new CompleteOrder(
            $this->order,
            $this->amount,
            new OrderShipmentDtosCollection(
                [
                    OrderShipmentDto::withPackage(
                        OrderPackageDto::withItem($itemDto),
                        $itemDto->distributor->id,
                        $itemDto->product->isDigital()
                    )->order($this->order)
                ]
            )
        ))
            ->isPaid(true)
            ->execute();

        SendSiteMailable::dispatch(
            $this->site,
            (new MembershipHasBeenAutoRenewed($this->account))
                ->order($this->order)
                ->membership($this->newMembership)
        );

        return $this;
    }
}
