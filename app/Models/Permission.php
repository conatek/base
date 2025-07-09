<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as SpatiePermission;
use App\Models\Module;

class Permission extends SpatiePermission
{
    // Aquí podemos personalizar relaciones adicionales
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
