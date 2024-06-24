<?php

namespace Domain\Sites\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DisplayTheme
 *
 * @property int $id
 * @property string $name
 * @property string $folder
 *
 * @property SitesTheme $sites_theme
 *
 * @package Domain\Display\Models
 */
class Theme extends Model
{
    public $timestamps = false;
    protected $table = 'display_themes';

    protected $fillable = [
        'name',
        'folder',
    ];

    //  public function sites()
    //  {
//      return $this->hasOne(SitesTheme::class, 'theme_id');
    //  }
}
