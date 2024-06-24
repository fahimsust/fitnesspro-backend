<?php

namespace Support\Mail;

use Domain\Sites\Actions\SendMailFromSite;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class MailerMailable extends AbstractMailable implements MailableContract
{
    use Queueable, SerializesModels;

    /**
     * @var SendMailFromSite
     */
    private SendMailFromSite $appMailer;

    /**
     * Create a new message instance.
     *
     * @param SendMailFromSite $mailer
     */
    public function __construct(SendMailFromSite $mailer)
    {
        $this->appMailer = $mailer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mailer = $this->appMailer;

        $this->from($mailer->from_email, $mailer->from_name)
            ->to($mailer->to_email, $mailer->to_name)
            ->subject($mailer->subject);

        if ($mailer->plain_text) {
            $this->plainText($mailer->plain_text);
        }

        if ($mailer->html) {
            $this->html($mailer->html);
        }

        return $this;
    }

    public function prep()
    {
        return $this;
    }

    public function prepMailer(SendMailFromSite $mailer)//not used here since appMailer is set
    {
        parent::prepMailer($mailer);

        $mailer->to(
            $this->appMailer->to_email,
            $this->appMailer->to_name
        );

        return $this;
    }
}
