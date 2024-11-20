<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Settings extends Model
{
    use LogsActivity;

    protected $fillable = [
        'project_title',
        'project_description',
        'bank_name',
        'merchant_id',
        'prov_user_id',
        'provision_password',
        'terminal_id',
        'store_key',
        'pos_url'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }
}
