<?php

namespace Domain\Accounts\Actions\Registration\Mail;

use Domain\Accounts\Models\Registration\Registration;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Actions\HandleSiteAccountMessageKeys;
use Support\Contracts\Mail\CanMailTo;

class SendRecoveryEmail extends AbstractRegistrationSendAction
{
    use AsObject;

    public function handle(Registration $registration)
    {
        parent::handle($registration);
    }

    public function handleMessageKeys()
    {
        return HandleSiteAccountMessageKeys::run($this->site, $this->account, [
            'REGISTRATION_REOVERY_LINK_HTML' => url(route('registration.recovery.recover', ['recovery_hash' => $this->registration->recovery_hash])),
        ]);
    }

    public function mailTo(): CanMailTo
    {
        return $this->account;
    }
}
