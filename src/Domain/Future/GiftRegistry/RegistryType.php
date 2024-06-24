<?php

namespace Domain\Future\GiftRegistry;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GiftregistryType
 *
 * @property int $id
 * @property string $name
 * @property bool $status
 *
 * @package App\Models
 */
class RegistryType extends Model
{
    public $timestamps = false;
    protected $table = 'giftregistry_types';

    protected $casts = [
        'status' => 'bool',
    ];

    protected $fillable = [
        'name',
        'status',
    ];

    public function registries()
    {
        //TODO update giftregistry.registry_type to be fk
        return $this->hasMany(GiftRegistry::class, 'registry_type');
    }
}
