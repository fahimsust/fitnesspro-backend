<?php

namespace Domain\Support\Actions\Mail;

use App\Api\Support\Requests\SupportEmailRequest;
use Domain\Sites\Models\Site;
use Domain\Support\Models\SupportDepartment;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Actions\BuildCustomMailable;

class SendSupportEmail
{
    use AsObject;

    public SupportDepartment $supportDepartment;
    public SupportEmailRequest $request;

    public function handle(
        SupportEmailRequest $request,
        Site $site
    ): void {
        $this->supportDepartment = SupportDepartment::findOrFail($request->support_department_id);
        $this->request = $request;

        BuildCustomMailable::run(
            subject: $this->subject(),
            plainText: $this->request->message,
            mailTo: $this->supportDepartment,
            mailFrom: $site
        )
            ->replyTo($this->request->email)
            ->queueIt();
    }

    private function subject(): string
    {
        return '(' . ucfirst($this->request->origin) . ') '
            . $this->supportDepartment->subject;
    }
}
