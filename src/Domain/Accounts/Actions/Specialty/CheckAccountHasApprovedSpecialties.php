<?php

namespace Domain\Accounts\Actions\Specialty;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Specialty;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Enums\MatchAllAnyInt;
use Support\Traits\HasExceptionCollection;

class CheckAccountHasApprovedSpecialties
{
    use AsObject,
        HasExceptionCollection;

    private bool $passed;
    private Account $account;
    private MatchAllAnyInt $matchOption;

    public function handle(
        Account $account,
        Collection $specialties,
        MatchAllAnyInt $matchOption
    ): bool {
        $this->account = $account;
        $this->matchOption = $matchOption;

        if (!$specialties->count()) {
            throw new \Exception(__('No specialties provided'));
        }

        if (!$account->approvedSpecialties->count()) {
            throw new \Exception(__('Account has no approved specialties'));
        }

        $this->passed = false;

        $specialties->each(
            fn (Specialty $specialty) => $this->checkSpecialty($specialty)
        );

        return $this->passed;
    }

    private function checkSpecialty(Specialty $specialty)
    {
        try {
            if ($this->account->approvedSpecialties->pluck('id')->doesntContain($specialty->id)) {
                throw new \Exception(__('Account not approved for specialty :specialty', [
                    'specialty' => $specialty->name,
                ]));
            }

            $this->passed = true;
        } catch (\Exception $exception) {
            if ($this->matchOption === MatchAllAnyInt::ALL) {
                throw $exception;
            }

            $this->catchToCollection($exception);
        }
    }
}
