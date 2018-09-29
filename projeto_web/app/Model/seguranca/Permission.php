<?php

namespace App\Model\seguranca;

use Illuminate\Database\Eloquent\Model;
use App\Model\seguranca\Permission;

class Permission extends Model
{
      
    public function roles(){
        return $this->belongsToMany(Role::class);
    }
}
