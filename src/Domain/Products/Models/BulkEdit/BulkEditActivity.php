<?php

namespace Domain\Products\Models\BulkEdit;

use Carbon\Carbon;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class BulkeditChange
 *
 * @property int $id
 * @property Carbon $created
 * @property string $action_type
 * @property string $action_changeto
 * @property int $products_edited
 *
 * @property Collection|array<Product> $products
 *
 * @package Domain\Products\Models
 */
class BulkEditActivity extends Model
{
    use HasModelUtilities;
    public $timestamps = false;
    protected $table = 'bulkedit_change';

    protected $casts = [
        'products_edited' => 'int',
        'created' => 'datetime',
        'action_type'=>ActionList::class
    ];

    protected $fillable = [
        'created',
        'action_type',
        'action_changeto',
        'products_edited',
    ];

    public function products()
    {
        //todo
        return $this->hasManyThrough(
            Product::class,
            BulkEditActivityProduct::class,
            'change_id'
        )
            ->withPivot('changed_from');
    }
}
