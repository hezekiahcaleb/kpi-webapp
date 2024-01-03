<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormMapping extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function roles(){
        return $this->belongsToMany(Role::class, 'role_id');
    }

    public function forms(){
        return $this->belongsToMany(Form::class, 'form_id');
    }
}
