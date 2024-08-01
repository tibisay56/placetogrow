<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $table = 'payments_settings';

    protected $fillable = [
        'site_id',
        'currency',
        'expiration_time',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
