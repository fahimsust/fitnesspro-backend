<?php

namespace Domain\Sites\Actions;

use Domain\Accounts\Models\Account;
use Domain\Sites\Models\Site;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Support\Mail\AbstractMailable;
use Support\Mail\MailerMailable;

class SendMailFromSite
{
    public $to_email;

    public $to_name;

    public $from_name;

    public $from_email;

    public $subject;

    public $html;

    public $plain_text;

    /**
     * @var Site|null
     */
    private ?Site $site = null;

    /**
     * @var Mailable
     */
    private Mailable $mailable;

    public function __construct(?Site $site = null)
    {
        $this->site = $site ?? app(Site::class);

        $this->from($this->site->email, $this->site->name);
    }

    public function mailable(AbstractMailable $mailable)
    {
        $this->mailable = $mailable->setSite($this->site);

        $mailable->prepMailer($this);

        return $this;
    }

    public function to($email, $name): static
    {
        $this->to_email = $email;
        $this->to_name = $name;

        return $this;
    }

    public function toAccount(Account $account): static
    {
        $this->to_email = $account->email;
        $this->to_name = $account->fullname;

        return $this;
    }

    public function from($email, $name)
    {
        $this->from_email = $email;
        $this->from_name = $name;

        return $this;
    }

    public function subject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    public function html($html)
    {
        $this->html = str_replace('{PLACEHOLDER}', $html, $this->site->messageTemplate->html);

        return $this;
    }

    public function plainText($plain_text)
    {
        $this->plain_text = str_replace('{PLACEHOLDER}', $plain_text, $this->site->messageTemplate->alt);

        return $this;
    }

    protected function mail(): \Illuminate\Mail\PendingMail
    {
        return Mail::to($this->to_email);
    }

    public function queueMailable(): void
    {
        $this->mail()
            ->queue($this->mailable);
    }

    public function sendMailable(): void
    {
        if (! $this->to_email) {
            throw new \Exception('No To Email set');
        }

        $this->mail()
            ->send($this->mailable);
    }

    public function send(): void
    {
        $this->mail()
            ->send(new MailerMailable($this));
    }

    public function queue(): void
    {
        $this->mail()
            ->queue(new MailerMailable($this));
    }

    public static function SendWithMailable(Site $site, AbstractMailable $mailable)
    {
        static::WithMailable($site, $mailable)->sendMailable();
    }

    public static function QueueWithMailable(Site $site, AbstractMailable $mailable)
    {
        static::WithMailable($site, $mailable)->queueMailable();
    }

    public static function WithMailable(Site $site, AbstractMailable $mailable)
    {
        return (new static($site))
            ->mailable($mailable);
    }
}
