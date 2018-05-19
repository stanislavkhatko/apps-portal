<?php

namespace App\Models;

use App\Scopes\AdultScope;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Facades\Storage;

class ContentItem extends Model
{
    use HasTranslations;

    protected $guarded = [];
    protected $translatable = ['title', 'description'];
    protected $casts = ['compatibility' => 'array', 'download' => 'array', 'is_customized' => 'boolean'];
    protected $appends = ['titleTranslated'];
    protected $fillable = ['category_id', 'provider', 'type', 'title', 'description', 'compatibility', 'preview', 'remote_id', 'download', 'is_customized', 'rating'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function localCategory()
    {
        return $this->belongsToMany(LocalCategory::class, 'local_category_content_item');
    }

    public function downloads()
    {
        return $this->hasMany(ContentDownload::class);
    }

    public function downloadedBy($subscription)
    {
        \App\Models\ContentDownload::create([
            'subscription_id' => $subscription['subscription_id'],
            'msisdn' => $subscription['msisdn'],
            'content_item_id' => $this->id,
            'item' => [
                'title' => $this->title,
                'remote_id' => $this->remote_id,
            ]
        ]);
    }

    public function getShortDescriptionAttribute()
    {
        $description = $this->description;

        if (strlen($description) > 130) {
            $description = substr($description, 0, 130) . '...';
        }

        return $description;
    }

    public function getTitleTranslatedAttribute()
    {
        return $this->title;
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
