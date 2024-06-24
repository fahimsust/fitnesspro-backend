<?php

namespace Domain\Content\Models;

use Domain\Content\QueryBuilders\ElementQuery;
use Domain\Products\Models\SearchForm\SearchFormField;
use Domain\Sites\Models\SitePackingSlip;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class Element
 *
 * @property int $id
 * @property string $title
 * @property string $notes
 * @property string $content
 * @property bool $status
 *
 * @package Domain\Others\Models
 */
class Element extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'elements';

    protected $casts = [
        'status' => 'bool',
    ];

    public function newEloquentBuilder($query)
    {
        return new ElementQuery($query);
    }
    public function searchFormFields()
    {
        return $this->hasMany(SearchFormField::class, 'help_element_id');
    }
    public function sitePackingSlips()
    {
        return $this->hasMany(SitePackingSlip::class, 'packingslip_appendix_elementid');
    }
    public function translations()
    {
        return $this->hasMany(
            ElementTranslation::class
        );
    }
}
