<?php

namespace Support\Actions;

use Lorisleiva\Actions\Concerns\AsObject;
use Support\Contracts\Mail\CanMailFrom;
use Support\Contracts\Mail\CanMailTo;
use Support\Mail\CustomMailable;

class BuildCustomMailable
{
    use AsObject;

    public function handle(
        CanMailTo $mailTo,
        CanMailFrom $mailFrom,
        string $subject,
        string $plainText,
        ?string $html = null,
    ): CustomMailable {
        return (new CustomMailable(
            $subject,
            $plainText,
            $html,
        ))
            ->to($mailTo->sendTo(), $mailTo->sendToName())
            ->from($mailFrom->sendFrom(), $mailFrom->sendFromName())
            ->build();
    }
}
