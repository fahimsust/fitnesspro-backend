<?php

namespace Domain\Accounts\Actions\Registration\Mail;

use Support\Contracts\Mail\CanMailFrom;
use Support\Contracts\Mail\CanMailTo;

class SendRegistrationEmailToAdmin extends AbstractSignUpSendAction
{
    public function templateField(): string
    {
        return 'email_template_id_creation_admin';
    }

    public function mailTo(): CanMailTo
    {
        return $this->site;
    }

    public function mailFrom(): CanMailFrom
    {
        return $this->account;
    }
}
