<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Form;

class Role extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function parent(){
        return $this->belongsTo(Role::class, 'parent_id');
    }

    public function children(){
        return $this->hasMany(Role::class, 'parent_id');
    }

    public function users(){
        return $this->hasMany(User::class, 'role_id');
    }

    public function forms(){
        return $this->belongsToMany(Form::class, 'form_mappings', 'role_id', 'form_id');
    }
}
