<?php

namespace Domain\Messaging\Actions;

use Domain\Messaging\Models\MessageTemplate;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Contracts\Mail\CanMailFrom;
use Support\Contracts\Mail\CanMailTo;
use Support\Mail\MessageTemplateMailable;

class BuildMessageTemplateMailable
{
    use AsObject;

    public function handle(
        MessageTemplate $template,
        CanMailTo $mailTo,
        CanMailFrom $mailFrom
    ): MessageTemplateMailable {
        return (new MessageTemplateMailable($template))
            ->to($mailTo->sendTo(), $mailTo->sendToName())
            ->from($mailFrom->sendFrom(), $mailFrom->sendFromName());
    }
}
