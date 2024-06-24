<?php

namespace Domain\Discounts\QueryBuilders;

use Domain\Accounts\Models\Account;
use Domain\Discounts\Enums\DiscountRelations;
use Domain\Discounts\Models\Discount;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsObject;

class AvailableDiscountsQuery
{
    use AsObject;

    private \Illuminate\Database\Eloquent\Builder $query;

    private \Illuminate\Support\Carbon $now;

    private Collection $excludeDiscountIds;
    private Account $account;
    private ?bool $checkAccountLimit = null;
    private bool $includeAccount = false;

    public function __construct()
    {
        $this->now = now();

        $this->query = self::startQuery()
            ->active()
            ->where('discount.limit_uses', '>=', 0);
    }

//    public function with(...$args): static
//    {
//        $this->query->with(...$args);
//
//        return $this;
//    }
//    public function where(...$args): static
//    {
//        $this->query->where(...$args);
//
//        return $this;
//    }

    //pass method calls to query
    public function __call(string $name, array $arguments)
    {
        if (method_exists($this->query, $name)) {
            $this->query->$name(...$arguments);

            return $this;
        }
    }

    public static function startQuery()
    {
        return Discount::from(Discount::Table() . ' as discount')
            ->select(self::selectFields());
    }

    public static function selectFields(): array
    {
        return [
            'discount.id',
            'discount.start_date',
            'discount.exp_date',
            'discount.limit_per_customer',
        ];
    }

    public function excludeDiscountIds(?Collection $excludeIds): static
    {
        if (is_null($excludeIds) || ! $excludeIds->count()) {
            return $this;
        }

        $this->excludeDiscountIds = $excludeIds;

        $this->query->whereNotIn('discount.id', $excludeIds);

        return $this;
    }

    public function includeAccount(?Account $account, bool $checkLimit = true): static
    {
        if (
            is_null($account) //no account provided
            || $this->includeAccount //account already included
        ) {
            return $this;
        }

        $this->account = $account;
        $this->checkAccountLimit = $checkLimit;
        $this->includeAccount = true;

        $this->query
            ->addSelect(DB::raw('SUM(IFNULL(accountUses.times_used, 0)) as discount_used'));

        return $this;
    }

    public function checkDate(): static
    {
        $this->query
            ->where(
                fn (Builder $query) => $query
                    ->where('discount.start_date', '<=', $this->now)
                    ->orWhereNull('discount.start_date')
            )
            ->where(
                fn (Builder $query) => $query
                    ->where('discount.exp_date', '>=', $this->now)
                    ->orWhereNull('discount.exp_date')
            );

        return $this;
    }

    public function handle(): Builder
    {
        return $this->query
            ->joinRelationship(
                DiscountRelations::ADVANTAGES,
                fn ($join) => $join->as('advantages')
            )
            ->joinRelationship(
                DiscountRelations::CONDITIONS
            )
            ->when(
                $this->includeAccount,
                fn ($query) => $query
                    ->leftJoin(
                        'accounts_discounts_used as accountUses',
                        function ($join) {
                            $join
                                ->on('discount.limit_per_customer', '>', DB::raw('0'))
                                ->on('accountUses.account_id', DB::raw($this->account->id));
                        }
                    )
            )
            ->when(
                $this->checkAccountLimit !== null,
                fn (Builder $query) => $query->groupBy(
                    DB::raw('discount.id HAVING SUM(IFNULL(accountUses.times_used, 0)) < discount.limit_per_customer'
                        . ' OR discount.limit_per_customer=0')
                ),
                fn (Builder $query) => $query->groupBy('discount.id')
            );
    }
    /*
     *
            function getAvailableDiscountsQuery($checked = "", $check_date = 1, $check_customer_limit=true){
                $now = Date::current("Y-m-d H:i:s");

                //Check for start date
                $qg = new BuildWhereGroup("", "OR");
                $qg->addWhereToGroup("d.start_date", $now, "<=");
                $qg->addWhereToGroup("d.start_date", "0000-00-00 00:00:00");

                //Check for expiration date
                $qg2 = new BuildWhereGroup("", "OR");
                $qg2->addWhereToGroup("d.exp_date", $now, ">=");
                $qg2->addWhereToGroup("d.exp_date", "0000-00-00 00:00:00");

                $q = new BuildSelect("SELECT d.id, d.start_date, d.exp_date, d.limit_per_customer
    FROM discount d
    JOIN discount_advantage adv ON adv.discount_id=d.id
    JOIN discount_rule r ON r.discount_id=d.id
    JOIN discount_rule_condition c ON c.rule_id=r.id");
                $q->setGroupBy("d.id");
                if($this->customer && $this->customer->isLoggedIn()){
                    $q->addToQuery(" LEFT JOIN accounts_discounts_used au ON d.limit_per_customer > 0 AND au.account_id='".DB::clean($this->customer->get('id'))."' AND au.discount_id=d.id");
                    $q->addToSelect("SUM(IFNULL(au.times_used, 0)) as discount_used, ");
                    if($check_customer_limit) $q->setGroupBy("d.id HAVING SUM(IFNULL(au.times_used, 0)) < d.limit_per_customer OR d.limit_per_customer='0'");
                }
                $q->addWhere("d.status", 1);
                $q->addWhere("d.limit_uses", 0, ">=");
                if($checked != "" && count($checked) > 0)$q->addWhere("d.id", $checked, "NOT IN");
                if($check_date > 0){
                    $q->addCustomWhere($qg->getGroupQuery());
                    $q->addCustomWhere($qg2->getGroupQuery());
                }
                return $q;
            }
     */
}
