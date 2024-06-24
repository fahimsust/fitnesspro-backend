<?php

namespace Domain\Accounts\Models\Certifications;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ModsAccountCertification
 *
 * @property int $id
 * @property int $account_id
 * @property string $cert_num
 * @property Carbon|null $cert_exp
 * @property string $cert_type
 * @property string $cert_org
 * @property bool $approval_status
 * @property Carbon $created
 * @property Carbon $updated
 * @property string $file_name
 *
 * @property Account $account
 * @property Collection|array<CertificationFile> $mods_account_certifications_files
 *
 * @package Domain\Accounts\Models\Mods
 */
class Certification extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;

    public const CREATED_AT = 'created';

    public const UPDATED_AT = 'updated_at';
    protected $table = 'account_certifications';

    protected $casts = [
        'account_id' => 'int',
        'approval_status' => 'bool',
        'cert_exp' => 'datetime',
    ];

    protected $fillable = [
        'account_id',
        'cert_num',
        'cert_exp',
        'cert_type',
        'cert_org',
        'approval_status',
        'file_name',
    ];

    public function certifee()
    {
        return $this->belongsTo(Account::class);
    }

    public function files()
    {
        return $this->hasMany(CertificationFile::class, 'certification_id');
    }
}
