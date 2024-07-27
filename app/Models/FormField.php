<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    protected $fillable = ['form_id', 'name', 'type', 'label', 'required'];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
