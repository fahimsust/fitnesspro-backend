<?php

namespace Support\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class CustomMailable extends AbstractMailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $customSubject,
        public string $plainText,
        public ?string $htmlMessage = null
    ) {
    }

    public function build(): static
    {
        return $this
            ->subject($this->customSubject)
            ->html($this->htmlMessage ?? nl2br($this->plainText))
            ->plainText($this->plainText ?? $this->htmlMessage);
    }
}
