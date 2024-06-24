<?php

namespace Domain\Accounts\Actions\Registration;

use Domain\Accounts\Exceptions\RegistrationNotFoundException;
use Domain\Accounts\Models\Registration\Registration;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;
use function __;

class LoadRegistrationById extends AbstractAction
{
    public function __construct(
        public int  $registrationId,
        public bool $useCache = true,
    )
    {
    }

    public function execute(): Registration
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::tags([
            "registration-cache.{$this->registrationId}",
        ])
            ->remember(
                "registration-by-id-{$this->registrationId}",
                60 * 5,
                fn() => $this->load()
            );
    }

    protected function load(): Registration
    {
        return Registration::find($this->registrationId)
            ?? throw new RegistrationNotFoundException(
                __("Registration with id {$this->registrationId} not found")
            );
    }
}
