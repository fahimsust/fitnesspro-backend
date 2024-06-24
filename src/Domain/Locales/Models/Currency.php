<?php

namespace Domain\Locales\Models;

use Domain\Locales\Models\QueryBuilders\CurrencyQuery;
use Domain\Sites\Models\SiteCurrency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class Currency extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;

    protected $table = 'currencies';

    protected $casts = [
        'status' => 'bool',
        'exchange_rate' => 'float',
        'exchange_api' => 'bool',
        'base' => 'bool',
        'decimal_places' => 'bool',
    ];

    protected $fillable = [
        'name',
        'code',
        'status',
        'exchange_rate',
        'exchange_api',
        'base',
        'decimal_places',
        'decimal_separator',
        'locale_code',
        'format',
        'symbol',
    ];
    public function newEloquentBuilder($query)
    {
        return new CurrencyQuery($query);
    }

    public function sites()
    {
        return $this->hasMany(SiteCurrency::class);
    }
}
