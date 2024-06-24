<?php

namespace Domain\Accounts\Actions\Registration\Mail;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountType;
use Domain\Messaging\Actions\BuildMessageTemplateMailable;
use Domain\Messaging\Models\MessageTemplate;
use Domain\Sites\Models\Site;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Actions\HandleSiteAccountMessageKeys;
use Support\Contracts\Mail\CanMailFrom;
use Support\Contracts\Mail\CanMailTo;

abstract class AbstractSignUpSendAction
{
    use AsObject;

    public Site $site;
    public Account $account;
    public AccountType $type;

    public MessageTemplate $template;

    public function handle(Account $account)
    {
        $this->loadDataFromAccount($account)
            ->buildAndQueueMailable();
    }

    public function loadDataFromAccount(Account $account): static
    {
        $this->account = $account;
        $this->type = $account->loadMissingReturn('type');
        $this->site = $account->loadMissingReturn('site');

        return $this;
    }

    public function buildAndQueueMailable()
    {
        if (!$this->type->{$this->templateField()}) {
            return;
        }

        BuildMessageTemplateMailable::run(
            template: $this->loadTemplate(),
            mailTo: $this->mailTo(),
            mailFrom: $this->mailFrom()
        )
            ->queueIt();
    }

    public function loadTemplate(): MessageTemplate
    {
        return $this->template = MessageTemplate::findOrFail(
            $this->type->{$this->templateField()}
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

    abstract public function templateField(): string;
}
