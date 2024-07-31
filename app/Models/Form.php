<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = 'forms';

    protected $fillable = ['site_id', 'name', 'type', 'currency', 'expiration_time'];


    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function fields()
    {
        return $this->hasMany(FormField::class);
    }
}
