<?php

namespace Domain\Orders\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OrderQuery extends Builder
{

    public function basicKeywordSearch(string $keyword)
    {
        if (!$keyword) {
            return $this;
        }
        $columns = ['id', 'order_phone', 'order_email'];
        return $this->where(function ($query) use ($columns, $keyword) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'LIKE', "%{$keyword}%");
            }

            $query->orWhereHas('billingAddress', function ($subQuery) use ($keyword) {
                $subQuery->where('first_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('last_name', 'LIKE', "%{$keyword}%");
            });

            $query->orWhereHas('account', function ($subQuery) use ($keyword) {
                $subQuery->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$keyword}%"])
                    ->orWhere('first_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('last_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('email', 'LIKE', "%{$keyword}%");
            });

            $query->orWhereHas('shippingAddress', function ($subQuery) use ($keyword) {
                $subQuery->where('first_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('last_name', 'LIKE', "%{$keyword}%");
            });
        });
    }
    public function search(Request $request): static
    {
        $request
            ->whenFilled(
                'keyword',
                fn() => $this->basicKeywordSearch($request->keyword) && false
            );
        if ($request->filled('order_no')) {
            $this->where('order_no', $request->order_no);
        }
        if ($request->filled('status_id')) {
            $this->whereHas('shipments', function ($subQuery) use ($request) {
                $subQuery->where('order_status_id', $request->status_id);
            });
        }
        if ($request->filled('distributor_id')) {
            $this->whereHas('shipments', function ($subQuery) use ($request) {
                $subQuery->where('distributor_id', $request->distributor_id);
            });
        }
        if ($request->filled('payment_method_id')) {
            $this->where('payment_method', $request->payment_method_id);
        }
        if ($request->filled('shipping_method_id')) {
            $this->whereHas('shipments', function ($subQuery) use ($request) {
                $subQuery->where('ship_method_id', $request->shipping_method_id);
            });
        }
        if ($request->filled('product_type_id')) {
            $this->whereHas('items', function ($itemQuery) use ($request) {
                $itemQuery->where(
                    function ($query) use ($request) {
                        $query->where(
                            function ($query2) use ($request) {
                                $query2->where('parent_product_id', '!=', NULL)->whereHas('productDetailsParent', function ($subQuery) use ($request) {
                                    $subQuery->where('type_id', $request->product_type_id);
                                });
                            }
                        );
                        $query->orWhere(
                            function ($query2) use ($request) {
                                $query2->where('parent_product_id', NULL)->whereHas('productDetails', function ($subQuery) use ($request) {
                                    $subQuery->where('type_id', $request->product_type_id);
                                });
                            }
                        );
                    }
                );
            });
        }
        if ($request->filled('state_id')) {
            $this->where(
                function ($query) use ($request) {
                    $query->orWhereHas('billingAddress', function ($subQuery) use ($request) {
                        $subQuery->where('state_id', $request->state_id);
                    });
                    $query->orWhereHas('shippingAddress', function ($subQuery) use ($request) {
                        $subQuery->where('state_id', $request->state_id);
                    });
                }
            );
        }
        if ($request->filled('country_id')) {
            $this->where(
                function ($query) use ($request) {
                    $query->orWhereHas('billingAddress', function ($subQuery) use ($request) {
                        $subQuery->where('country_id', $request->country_id);
                    });
                    $query->orWhereHas('shippingAddress', function ($subQuery) use ($request) {
                        $subQuery->where('country_id', $request->country_id);
                    });
                }
            );
        }
        if ($request->anyFilled(['start_date', 'end_date'])) {
            if ($request->Filled(['start_date', 'end_date'])) {
                $this->where('created_at', '>=', $request->start_date)
                    ->where('created_at', '<=', $request->end_date);
            } else if ($request->Filled('start_date')) {
                $this->where('created_at', '>=', $request->start_date);
            } else if ($request->Filled('end_date')) {
                $this->where('created_at', '<=', $request->end_date);
            }
        }
        if ($request->anyFilled(['start_date_travel', 'end_date_travel'])) {
            $this->whereHas('rangeOption', function ($query) use ($request) {
                $query->whereHas('optionValues', function ($subQuery) use ($request) {
                    $this->startEndDateConitionBetween($request, $subQuery);
                });
            });
        }
        return $this;
    }
    function startEndDateConitionBetween($request, Builder $query)
    {
        if ($request->Filled(['start_date_travel', 'end_date_travel'])) {
            $query->where(function ($subQueryMain) use ($request) {
                $subQueryMain->where(function ($subQuery) use ($request) {
                    $subQuery->whereBetween('start_date', [$request->start_date_travel, $request->end_date_travel]);
                    $subQuery->orWhereBetween('end_date', [$request->start_date_travel, $request->end_date_travel]);
                });
                $subQueryMain->orWhere(function ($subQuery) use ($request) {
                    $subQuery->where('start_date', '<=', $request->start_date_travel);
                    $subQuery->where('end_date', '>=', $request->end_date_travel);
                });
            });
        } else if ($request->Filled('start_date')) {
            $query->where('start_date', '<=', $request->start_date_travel);
            $query->where('end_date', '>=', $request->start_date_travel);
        } else if ($request->Filled('end_date')) {
            $query->where('start_date', '<=', $request->end_date_travel);
            $query->where('end_date', '>=', $request->end_date_travel);
        }
        return $query;
    }
}
