<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'description',
        'amount',
        'currency',
        'status',
        'gateway',
        'process_identifier',
        'payer_name',
        'payer_lastname',
        'payer_document_type',
        'payer_document_number',
        'payer_email',
        'site_id',
        'required_fields',
    ];

    protected $casts = [
        'required_fields' => 'array',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
