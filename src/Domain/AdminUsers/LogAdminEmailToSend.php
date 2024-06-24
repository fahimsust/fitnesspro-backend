<?php

namespace Domain\AdminUsers;

use Domain\Accounts\Models\Account;
use Domain\AdminUsers\Enums\AdminEmailSentStatuses;
use Domain\AdminUsers\Models\AdminEmailsSent;
use Support\Contracts\AbstractAction;

class LogAdminEmailToSend extends AbstractAction
{
    public function __construct(
        public Account $account,
        public string  $subject,
        public string  $body,
        public ?int    $messageTemplateId,
        public ?int    $adminUserId = null,
        public ?int    $orderId = null
    ) {
    }

    public function execute(): AdminEmailsSent
    {
        return AdminEmailsSent::create([
            'account_id' => $this->account->id,
            'sent_to' => $this->account->email,
            'template_id' => $this->messageTemplateId,
            'subject' => $this->subject,
            'content' => $this->body,
            'sent_by' => $this->adminUserId,
            'order_id' => $this->orderId,
            'status' => AdminEmailSentStatuses::Sending
        ]);
    }
}
