<?php

namespace Support\Mail;

use Domain\Messaging\Models\MessageTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class MessageTemplateMailable extends AbstractMailable
{
    use Queueable, SerializesModels;

    public function __construct(public MessageTemplate $template)
    {
    }

    public function build(): static
    {
        return $this
            ->subject($this->template->subject)
            ->html($this->template->html)
            ->plainText($this->template->plain_text);
    }
}
