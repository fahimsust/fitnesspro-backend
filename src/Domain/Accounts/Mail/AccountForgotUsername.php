<?php

namespace Domain\Accounts\Mail;

use Domain\Accounts\Models\Account;
use Domain\Messaging\Models\MessageTemplate;
use Domain\Sites\Actions\SendMailFromSite;
use Domain\Sites\Models\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Support\Helpers\HandleMessageKeys;
use Support\Mail\AbstractMailable;
use Support\Mail\MailableContract;

class AccountForgotUsername extends AbstractMailable implements MailableContract
{
    use Queueable, SerializesModels;

    private Account $account;

    private $username;

    private MessageTemplate $template;

    /**
     * Create a new message instance.
     *
     * @param Account $account
     * @param Site|null $site
     */
    public function __construct(Account $account, ?Site $site = null)
    {
        $this->account = $account;
        $this->username = $account->user;

        if ($site) {
            $this->setSite($site);
        }
    }

    public function prep()
    {
        parent::prep();

        $keyHandler = (new HandleMessageKeys([
            'ACCOUNT_LOGIN_LINK' => Account::url(),
        ]))
            ->setSite($this->site)
            ->setAccount($this->account);

        $this->template = MessageTemplate::FindBySystemId('forgot_username')
            ->replaceKeysUsingHandler($keyHandler);

        $this->siteMailer()
            ->html($this->template->html)
            ->plainText($this->template->plain_text);

        return $this;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->prep();

        return $this->from($this->site->email, $this->site->name)
            ->to($this->account->email, $this->account->first_name)
            ->subject($this->template->subject)
            ->plainText($this->siteMailer->plain_text)
            ->html($this->siteMailer->html);
    }

    public function prepMailer(SendMailFromSite $mailer)
    {
        $this->siteMailer = $mailer;
        $mailer->to($this->account->email, $this->account->first_name);

        return $this;
    }
}
