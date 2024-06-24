<?php

namespace Domain\Messaging\Mail;

use function __;
use Domain\Messaging\Requests\SupportContactRequest;
use Domain\Sites\Models\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Support\Mail\AbstractMailable;
use Support\Mail\MailableContract;

class SupportContact extends AbstractMailable implements MailableContract
{
    use Queueable, SerializesModels;

    /**
     * @var SupportContactRequest
     */
    public SupportContactRequest $request;

    /**
     * Create a new message instance.
     *
     * @param  SupportContactRequest  $request
     * @param  Site|null  $site
     */
    public function __construct(SupportContactRequest $request, ?Site $site = null)
    {
        $this->request = $request;

        $this->setSite($site);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->prep();

        return $this
            ->to($this->site->email, $this->site->name)
            ->subject(__('Contact from :site', ['site' => $this->site->name]))
            ->plainText($this->siteMailer->plain_text)
            ->html($this->siteMailer->html);
    }

    public function prep()
    {
        parent::prep();

        $variables = ['request' => $this->request];

        $this->siteMailer()
            ->html($this->renderView('mail.support', $variables))
            ->plainText($this->renderView('mail.support_plain', $variables));
    }
}
