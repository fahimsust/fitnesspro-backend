<?php

namespace Domain\Accounts\Actions\Registration\Mail;

use Support\Contracts\Mail\CanMailTo;

class SendEmailToCustomer extends AbstractSignUpSendAction
{
    public function mailTo(): CanMailTo
    {
        return $this->account;
    }

    public function templateField(): string
    {
        return 'email_template_id_creation_user';
    }
}
