<?php

namespace App\Model\seguranca;

use Illuminate\Database\Eloquent\Model;
use App\Model\seguranca\Permission;

class Role extends Model
{
    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }
}
