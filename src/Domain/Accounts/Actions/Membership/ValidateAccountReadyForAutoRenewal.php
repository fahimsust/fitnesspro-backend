<?php

namespace Domain\Accounts\Actions\Membership;

use Domain\Accounts\Exceptions\AutoRenewPaymentSetupException;
use Domain\Accounts\Exceptions\CreditCardException;
use Domain\Accounts\Mail\MembershipWillAutoRenewIn30Days;
use Domain\Accounts\Mail\UpdateCardExpirationForAutoRenewal;
use Domain\Accounts\Mail\UpdatePaymentSetupForAutoRenewal;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Cim\CimPaymentProfile;
use Domain\Sites\Models\Site;
use Illuminate\Contracts\Mail\Mailable;
use Support\Contracts\AbstractAction;

class ValidateAccountReadyForAutoRenewal extends AbstractAction
{
    public function __construct(
        public Account $account,
        public bool    $sendMails = false,
        public int     $expiresInDays = 30,
    )
    {
    }

    public function execute(): static
    {
        try {
            //payment profile is valid
            AutoRenewPaymentSetupException::CheckAutoRenewPaymentSettings($this->account->activeMembership);

            //will be valid in 30 days
            CreditCardException::CheckIfExpiresBefore(
                CimPaymentProfile::findOrFail($this->account->activeMembership->renew_payment_profile_id),
                now()->addDays($this->expiresInDays)
            );

            $this->mail(new MembershipWillAutoRenewIn30Days($this->account));
        } catch (AutoRenewPaymentSetupException $exception) {
            $this->mailOrThrow(
                new UpdatePaymentSetupForAutoRenewal($this->account),
                $exception
            );
        } catch (CreditCardException $exception) {
            $this->mailOrThrow(
                new UpdateCardExpirationForAutoRenewal($this->account),
                $exception
            );
        }

        return $this;
    }

    protected function mail(Mailable $mailable)
    {
        if (!$this->sendMails)
            return;

        Site::SendMailable($mailable);
    }

    protected function mailOrThrow(
        Mailable   $mailable,
        \Exception $exception
    )
    {
        if (!$this->sendMails)
            throw $exception;

        $this->mail($mailable);
    }
}
