<?php

namespace Domain\Accounts\Actions\Registration\Mail;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Messaging\Actions\BuildMessageTemplateMailable;
use Domain\Messaging\Models\MessageTemplate;
use Domain\Sites\Models\Site;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Actions\HandleSiteAccountMessageKeys;
use Support\Contracts\Mail\CanMailFrom;
use Support\Contracts\Mail\CanMailTo;

abstract class AbstractRegistrationSendAction
{
    use AsObject;

    public Site $site;
    public Account $account;
    public Registration $registration;

    public MessageTemplate $template;

    public function handle(Registration $registration)
    {
        $this->fromRegistration($registration)
            ->buildAndQueueMailable();
    }

    public function fromRegistration(Registration $registration): static
    {
        $this->account = $registration->loadMissingReturn('account');
        $this->site = $this->account->loadMissingReturn('site');
        $this->registration = $registration;

        return $this;
    }

    public function buildAndQueueMailable()
    {
        if (! config('registration.recovery_email_template_id')) {
            return;
        }

        BuildMessageTemplateMailable::run(
            template: $this->loadTemplate(),
            mailTo: $this->mailTo(),
            mailFrom: $this->mailFrom()
        )->queueIt();
    }

    public function loadTemplate(): MessageTemplate
    {
        return $this->template = MessageTemplate::findOrFail(
            config('registration.recovery_email_template_id')
        )->replaceKeysUsingHandler(
            $this->handleMessageKeys()
        );
    }

    public function handleMessageKeys()
    {
        return HandleSiteAccountMessageKeys::run($this->site, $this->account);
    }

    abstract public function mailTo(): CanMailTo;

    public function mailFrom(): CanMailFrom
    {
        return $this->site;
    }
}
