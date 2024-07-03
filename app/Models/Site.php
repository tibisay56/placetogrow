<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'avatar',
        'category',
        'currency',
        'payment_expiration_time',
        'type_id',
        'user_id',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

}
