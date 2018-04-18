<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Facades\Storage;

class LocalContentType extends Model
{
    use HasTranslations;

    protected $translatable = ['label'];
    protected $fillable = ['name', 'label', 'icon'];

    public function localCategories()
    {
        return $this->hasMany(LocalCategory::class);
    }

    public function portals()
    {
        return $this->belongsToMany(ContentPortal::class);
    }

    public function getContentItemsAttribute()
    {
        //return $this->hasManyThrough(ContentItem::class, LocalCategory::class);
        return $this->localCategories->pluck('contentItems')->collapse()->values();
    }

    public function getIconAttribute($value)
    {
        if (Storage::disk('spaces')->exists($value)) {
            return Storage::disk('spaces')->url($value);
        }

        return $value;
    }

    public function setIconAttribute($value)
    {
        if ($value && strstr($value, '.com/')) {
            $value = substr($value, strpos($value, '.com/') + 5);
        }

        $this->attributes['icon'] = $value;
    }

    public function getCreatedAtAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }
    
    public function getUpdatedAtAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }
}
