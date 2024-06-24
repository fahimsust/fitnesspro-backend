<?php

namespace Domain\Accounts\Actions\Registration\Mail;

use Domain\Accounts\Enums\AccountStatus;
use Domain\Accounts\Models\Account;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Actions\HandleSiteAccountMessageKeys;
use Support\Contracts\Mail\CanMailTo;
use function url;

class SendVerificationEmail extends AbstractSignUpSendAction
{
    use AsObject;

    public function handle(Account $account)
    {
        if (! $account->loadMissingReturn('type')->verify_user_email) {
            return;
        }

        $account->update([
            'status_id' => AccountStatus::AWAITING_EMAIL_VERIFICATION,
        ]);

        parent::handle($account);
    }

    public function handleMessageKeys()
    {
        return HandleSiteAccountMessageKeys::run($this->site, $this->account, [
            'ACCOUNT_VERIFY_LINK_HTML' => url('account/verify-email-address?id=' . $this->account->id),
        ]);
    }

    public function mailTo(): CanMailTo
    {
        return $this->account;
    }

    public function templateField(): string
    {
        return 'email_template_id_verify_email';
    }
}
