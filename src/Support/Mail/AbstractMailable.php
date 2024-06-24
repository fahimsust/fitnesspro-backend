<?php

namespace Support\Mail;

use Domain\Sites\Actions\SendMailFromSite;
use Domain\Sites\Models\Site;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

abstract class AbstractMailable extends Mailable
{

    /**
     * @var Site|null
     */
    public ?Site $site = null;
    protected SendMailFromSite $siteMailer;

    public function setSite(?Site $site = null)
    {
        $this->site = $site ?? Site::Init();

        $this->from($this->site->email, $this->site->name);

        return $this;
    }

    public function prep()
    {
        if (! $this->site) {
            throw new \Exception(__('Site not set'));
        }

        $this->siteMailer();

        return $this;
    }

    public function prepMailer(SendMailFromSite $mailer)
    {
        $mailer->to($this->site->email, $this->site->name);

        return $this;
    }

    public function siteMailer()
    {
        return $this->siteMailer = $this->siteMailer ?? new SendMailFromSite($this->site);
    }

    public function queueIt()
    {
        Mail::queue($this);
    }

    protected function plainText($content)
    {
        if ($content) {
            $this->text('mail.plain_text', ['content' => $content]);
        }

        return $this;
    }

    protected function renderView($view, $variables)
    {
        return view($view, $variables)->render();
    }
}
