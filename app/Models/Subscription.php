<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use HasFactory;

    protected $casts = [
        'next_billing_date' => 'datetime',
    ];

    protected $fillable = [
        'plan_id',
        'user_id',
        'site_id',
        'start_date',
        'end_date',
        'status',
        'email',
        'name',
        'surname',
        'document_number',
        'document_type',
        'request_id',
        'status_message',
        'token',
        'sub_token',
        'next_billing_date',
        'plan_months',
        'months_charged',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
