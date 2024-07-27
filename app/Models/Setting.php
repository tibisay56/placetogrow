<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class PaymentSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'required_fields',
        'currency',
        'payment_expiration_time',
    ];

    protected $casts = [
        'required_fields' => 'array',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
