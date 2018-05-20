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

    public function contentItems()
    {
        // TODO relation
//        return $this->hasMany(LocalCategory::class);

        // 'local_category_content_item', 'local_category_id', 'local_category_content_item', 'id'


//        return $this->hasMany(ContentItem::class, 'id', 'local_category_content_item');
    }

    public function portals()
    {
        return $this->belongsToMany(ContentPortal::class);
    }

    public function getContentItemsAttribute()
    {
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
