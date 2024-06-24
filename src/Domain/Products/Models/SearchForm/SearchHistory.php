<?php

namespace Domain\Products\Models\SearchForm;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SearchHistory
 *
 * @property string $keywords
 * @property Carbon $created
 *
 * @package Domain\Products\Models\SearchForm
 */
class SearchHistory extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'search_history';

    protected $casts = [
        'created' => 'datetime',
    ];

    protected $fillable = [
        'keywords',
        'created',
    ];
}
