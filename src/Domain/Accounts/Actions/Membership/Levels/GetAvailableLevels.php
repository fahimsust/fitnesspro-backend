<?php

namespace Domain\Accounts\Actions\Membership\Levels;

use Domain\Accounts\Models\Membership\MembershipLevel;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;

class GetAvailableLevels extends AbstractAction
{
    public function __construct(
        public array $with = ['product' => [
            'pricingForCurrentSite' => [
                'pricingRule',
                'orderingRule'
            ]
        ]],
        public bool $onlyActiveLevels = true,
        public ?int  $membershipLevelId = null
    )
    {
    }

    public function execute(): Collection|MembershipLevel
    {
        if ($this->membershipLevelId) {
            return $this->query()->find($this->membershipLevelId)
                ?? throw new \Exception(
                    __(
                        "Membership level :id not found",
                        ['id' => $this->membershipLevelId]
                    )
                );
        }

        return $this->query()->get();
    }

    protected function query(): \Illuminate\Database\Eloquent\Builder
    {
        return MembershipLevel::with($this->with)
            ->when(
                $this->onlyActiveLevels,
                fn ($query) => $query->where('status', true)
            )
            ->orderBy('rank');
    }
}
