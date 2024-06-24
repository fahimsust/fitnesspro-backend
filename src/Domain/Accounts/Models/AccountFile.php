<?php

namespace Domain\Accounts\Models;

use Carbon\Carbon;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ModsAccountFile
 *
 * @property int $id
 * @property int $account_id
 * @property string $filename
 * @property Carbon $uploaded
 * @property int $site_id
 * @property bool $approval_status
 *
 * @property Account $account
 * @property Site $site
 *
 * @package Domain\Accounts\Models\Mods
 */
class AccountFile extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;
    protected $table = 'account_files';

    protected $casts = [
        'account_id' => 'int',
        'site_id' => 'int',
        'approval_status' => 'bool',
        'uploaded' => 'datetime',
    ];

    protected $fillable = [
        'account_id',
        'filename',
        'uploaded',
        'site_id',
        'approval_status',
    ];

    public function owner()
    {
        return $this->belongsTo(Account::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
