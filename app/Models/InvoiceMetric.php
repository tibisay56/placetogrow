<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'metrics',
        'site_id',
        'date',
    ];

    protected $casts = [
        'metrics' => 'array',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
