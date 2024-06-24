<?php

namespace Domain\Accounts\Jobs\Membership;


use Domain\Sites\Models\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Support\Mail\AbstractMailable;

class SendSiteMailable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public Site     $site,
        public AbstractMailable $mailable
    )
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->site->_sendMailable(
                $this->mailable
            );
        } catch (\Throwable $exception) {
            $this->fail($exception);

            throw $exception;
        }
    }
}
