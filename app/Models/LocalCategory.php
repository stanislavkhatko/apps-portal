<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Models\Category;

class LocalCategory extends Model
{
    use HasTranslations;
    
    protected $fillable = ['label', 'adult', 'provider_category_id', 'auto_sync_content_items'];
    protected $translatable = ['label'];

    public function localContentType()
    {
        return $this->belongsTo(LocalContentType::class);
    }

    public function contentItems()
    {
        return $this->belongsToMany(ContentItem::class, 'local_category_content_item');
    }
    
    public function getCategoryAttribute() {
        return Category::where('id', $this->provider_category_id)->first();
    }

    public function getContentTypeAttribute() {
        return Category::find($this->provider_category_id)->contentType;
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
