<?php

namespace Domain\Messaging\Models\AutomatedEmails;

use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AutomatedEmailsSite
 *
 * @property int $automated_email_id
 * @property int $site_id
 *
 * @property AutoEmail $automated_email
 * @property Site $site
 *
 * @package Domain\Messaging\Models
 */
class AutoEmailSite extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'automated_emails_sites';

    protected $casts = [
        'automated_email_id' => 'int',
        'site_id' => 'int',
    ];

    public function autoEmail()
    {
        return $this->belongsTo(AutoEmail::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
