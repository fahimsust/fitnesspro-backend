<?php

namespace Domain\Trips\QueryBuilders;

use Domain\Accounts\Models\Account;
use Illuminate\Support\Facades\Date;

class AccountTrip
{
    /**
     * @var Account
     */
    public Account $account;

    public $query;

    public function __construct(Account $account)
    {
        $this->account = $account;

        $this->config_resort_attribute = config('trips.resort_attribute_id'); //$resortAttributeId;
        $this->config_teaching_vacation_type = config('trips.vacation_type_id'); //$teachingVacationTypeId;
    }

    public static function StartQuery(Account $account)
    {
        $obj = new static($account);

        return $obj->createQuery()->builder;
    }

    /**
     * @param $msgTemplateId
     *
     * @return Query
     */
    public function createQuery($msgTemplateId = null): Query
    {
        $query = new Query($this->config_resort_attribute);

        $query->builder->where('account_id', '=', $this->account->id);

        if ($msgTemplateId) {
            $query->orderProductSentTemplateId($msgTemplateId);
            $query->builder
                ->whereRaw('e.email_id IS NULL');
        }

        $query->builder->groupBy('op.id');
//        dd(\App\Helpers\Query::toSql($query->builder));

        return $query;
    }

    public function all()
    {
        $query = $this->createQuery();

//        dump(\App\Helpers\Query::toSql($query->builder));

        return $query->builder->get();
    }

    public function first()
    {
        $query = $this->createQuery();
//        dd(\Support\Helpers\Query::toSql($query->builder));

//        dd($query->builder->get());
        return $query->builder->first();
    }

    public static function find(Account $account, $tripId)
    {
        return (new AccountTrip($account))->id($tripId);
    }

    public function id($tripId)
    {
        return $this->createQuery()
            ->builder
            ->where('op.id', '=', $tripId)
            ->first();
    }

    public function upcoming($daysFromNow = null, $msgTemplateId = null)
    {
        $start = 0;
        $limit = 20; //($this->test) ? 1:20;
        /*if($this->task = ModuleCronTask::loadByType($typeId)){
            $start = $this->task->start;
            $days_fromnow = $this->task->date;
        }else{
            $start = 0; if($_GET['start']) $start = $_GET['start'];
            $days_fromnow = Date::current("Y-m-d", mktime(0,0,0, Date::current("m"), Date::current("d") + $daysFromNow, Date::current("Y")));
        }*/

        $query = $this->createQuery($msgTemplateId);

        if ($daysFromNow) {
            $daysFromNowDate = Date::now()->addDays($daysFromNow)->format('Y-m-d');
            $query->builder->where('pov.start_date', '<=', $daysFromNowDate);
        }

        $startDate = Date::now()->format('Y-m-d');
        if ($daysFromNow === '90' && $startDate < '2020-10-28') {
            $startDate = '2020-10-28';
        }

        $query->builder
            ->where('pov.start_date', '>', $startDate)
            ->where('os.order_status_id', '=', 10)
            ->offset($start)
            ->limit($limit); //confirmed

//        dd($query->toSql());
        $query->groupByAccountAndProduct();

        return $query->builder->get();
    }

    public function past($msgTemplateId, $startDate = null, $endDate = null)
    {
        $start = 0;
        $limit = 20; //($this->test) ? 1:20;

        $query = $this->createQuery($msgTemplateId);

        if (! $startDate && ! $endDate) {
            $query->builder->where('pov.end_date', '<', Date::now()->format('Y-m-d'));
        }

        if ($endDate) {
            $query->builder->where('pov.end_date', '<', $endDate);
        }

        if ($startDate) {
            $query->builder->where('pov.end_date', '>', $startDate);
        }

        $query->builder
            ->whereNotIn('os.order_status_id', [7, 13])
            ->offset($start)
            ->limit($limit);

//        dd($query->toSql());
        $query->groupByAccountAndProduct();

        return $query->builder->get();
    }
}
