<?php

namespace Domain\Accounts\Mail;

use Domain\Accounts\Models\Account;
use Domain\Messaging\Models\MessageTemplate;
use Domain\Sites\Models\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Support\Helpers\HandleMessageKeys;
use Support\Mail\AbstractMailable;
use Support\Mail\MailableContract;

class AccountForgotPassword extends AbstractMailable implements MailableContract
{
    use Queueable, SerializesModels;

    /**
     * @var Account
     */
    public Account $account;

    /**
     * @var MessageTemplate
     */
    public MessageTemplate $template;

    private $newPassword;

    /**
     * Create a new message instance.
     *
     * @param  Account  $account
     * @param $newPassword
     * @param  Site|null  $site
     */
    public function __construct(Account $account, $newPassword, ?Site $site = null)
    {
        $this->account = $account;
        $this->newPassword = $newPassword;

        if ($site) {
            $this->setSite($site);
        }
    }

    public function prep()
    {
        parent::prep();

        $keyHandler = (new HandleMessageKeys([
            'NEW_PASSWORD' => $this->newPassword,
        ]))
            ->setSite($this->site)
            ->setAccount($this->account);

        $this->template = MessageTemplate::FindBySystemId('6')
            ->replaceKeysUsingHandler($keyHandler);

        $this->siteMailer()
            ->html($this->template->html)
            ->plainText($this->template->plain_text);

        return $this;
    }

    public function prepMailer(SiteMailer $mailer)
    {
        $this->siteMailer = $mailer;
        $mailer->to($this->account->email, $this->account->first_name);

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
}
