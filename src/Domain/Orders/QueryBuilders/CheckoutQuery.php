<?php

namespace Domain\Orders\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CheckoutQuery extends Builder
{
    public function search(?string $keyword)
    {
        if (!$keyword) {
            return $this;
        }
        return $this->where(function ($query) use ($keyword) {
            $query->orWhereHas('order', function ($subQuery) use ($keyword) {
                $subQuery->where('order_no', 'LIKE', "%{$keyword}%");
            });
            $query->orWhereHas('account', function ($subQuery) use ($keyword) {
                $subQuery->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$keyword}%"])
                    ->orWhere('first_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('last_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('email', 'LIKE', "%{$keyword}%");
            });
            $query->orWhereHas('site', function ($subQuery) use ($keyword) {
                $subQuery->where('name', 'LIKE', "%{$keyword}%");
            });
        });
    }
}
