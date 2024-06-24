<?php

namespace App\Observers\Accounts\Registration;

use Domain\Accounts\Models\Registration\Registration;
use Illuminate\Support\Facades\Cache;

class RegistrationObserver
{
    public function updated(Registration $registration)
    {
        $this->clearCache($registration);
    }

    public function deleted(Registration $registration)
    {
        $this->clearCache($registration);
    }

    public function forceDeleted(Registration $registration)
    {
        $this->clearCache($registration);
    }

    public function restored(Registration $registration)
    {
        $this->clearCache($registration);
    }

    protected function clearCache(Registration $registration)
    {
        $cacheKeys = [
            "registration-by-id-{$registration->id}"
        ];

        foreach($cacheKeys as $cacheKey) {
            Cache::forget($cacheKey);
        }
    }
}
