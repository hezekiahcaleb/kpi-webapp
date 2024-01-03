<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormDetail extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function form(){
        return $this->belongsTo(Form::class, 'form_id');
    }
}
