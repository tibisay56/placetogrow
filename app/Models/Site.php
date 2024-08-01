<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Site extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'avatar',
        'category',
        'currency',
        'payment_expiration_time',
        'type_id',
    ];


    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'site_user', 'user_id', 'site_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

}
