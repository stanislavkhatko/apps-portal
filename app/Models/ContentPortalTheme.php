<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentPortalTheme extends Model
{
    public function translations()
    {
        //
    }

    public function portals()
    {
        return $this->hasMany(ContentPortal::class);
    }
}
