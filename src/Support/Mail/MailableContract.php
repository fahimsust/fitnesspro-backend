<?php

namespace Support\Mail;

use Domain\Sites\Actions\SendMailFromSite;

interface MailableContract
{
    public function prep();

    public function prepMailer(SendMailFromSite $mailer);
}
