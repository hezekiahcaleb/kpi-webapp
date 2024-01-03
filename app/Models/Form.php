<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FormDetail;
use App\Models\Role;

class Form extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function formDetails(){
        return $this->hasMany(FormDetail::class, 'form_id');
    }

    public function roles(){
        return $this->belongsToMany(Role::class, 'form_mappings', 'form_id', 'role_id');
    }
}
