<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
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
}
