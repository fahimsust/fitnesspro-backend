<?php

namespace Domain\Messaging\Jobs;

use Domain\Accounts\Actions\LoadAccountByIdFromCache;
use Domain\Accounts\Models\Account;
use Domain\AdminUsers\Enums\AdminEmailSentStatuses;
use Domain\AdminUsers\Models\AdminEmailsSent;
use Domain\Sites\Actions\LoadSiteByIdFromCache;
use Domain\Sites\Actions\SendMailFromSite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAdminEmailToAccount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 1;

    private Account $account;

    public function __construct(
        public AdminEmailsSent $adminEmailToSend,
    ) {
    }

    public function handle()
    {
        try {
            (new SendMailFromSite(
                LoadSiteByIdFromCache::now(
                    $this->loadAccount()->site_id
                )
            ))
                ->toAccount($this->account)
                ->subject($this->adminEmailToSend->subject)
                ->html($this->adminEmailToSend->content)
                ->send();

            $this->adminEmailToSend->update([
                'status' => AdminEmailSentStatuses::Sent,
                'sent_date' => now(),
            ]);
        } catch (\Exception $e) {
            $this->adminEmailToSend->update([
                'status' => AdminEmailSentStatuses::Failed,
                'failed_data' => json_encode($e->getMessage()),
            ]);

            throw $e;
        }
    }

    protected function loadAccount(): Account
    {
        return $this->account = LoadAccountByIdFromCache::run(
            $this->adminEmailToSend->account_id
        );
    }
}
