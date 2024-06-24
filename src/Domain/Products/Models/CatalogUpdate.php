<?php

namespace Domain\Products\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CatalogUpdate
 *
 * @property int $id
 * @property string $type
 * @property int $item_id
 * @property bool $processing
 * @property int $start
 * @property string $info
 * @property int $modified
 *
 * @package Domain\Products\Models
 */
class CatalogUpdate extends Model
{
    public $timestamps = false;
    protected $table = 'catalog_updates';

    protected $casts = [
        'item_id' => 'int',
        'processing' => 'bool',
        'start' => 'int',
        'modified' => 'int',
    ];

    protected $fillable = [
        'type',
        'item_id',
        'processing',
        'start',
        'info',
        'modified',
    ];
}
