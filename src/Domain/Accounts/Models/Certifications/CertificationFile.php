<?php

namespace Domain\Accounts\Models\Certifications;

use Carbon\Carbon;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ModsAccountCertificationsFile
 *
 * @property int $id
 * @property int $certification_id
 * @property string $filename
 * @property Carbon $uploaded
 * @property bool $approval_status
 * @property int $site_id
 *
 * @property Certification $mods_account_certification
 * @property Site $site
 *
 * @package Domain\Accounts\Models\Mods
 */
class CertificationFile extends Model
{
    public $timestamps = false;
    protected $table = 'account_certifications_files';

    protected $casts = [
        'certification_id' => 'int',
        'approval_status' => 'bool',
        'site_id' => 'int',
        'uploaded' => 'datetime',
    ];

    protected $fillable = [
        'certification_id',
        'filename',
        'uploaded',
        'approval_status',
        'site_id',
    ];

    public function certification()
    {
        return $this->belongsTo(Certification::class, 'certification_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
