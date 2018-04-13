<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

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

    public function getCreatedAtAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }
    
    public function getUpdatedAtAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }
}
