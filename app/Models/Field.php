<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = ['site_id', 'name', 'type'];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
