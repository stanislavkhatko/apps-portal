<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContentType
 *
 * @property int $id
 * @property int $remote_id
 * @property string $label
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentType whereLabel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentType whereRemoteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentType whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $provider
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentType whereProvider($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ContentItem[] $contentItems
 */
class ContentType extends Model
{
    protected $guarded = [];
    protected $appends = [];
    protected $fillable = ['remote_id', 'label', 'provider'];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function contentItems()
    {
        return $this->hasManyThrough(ContentItem::class, Category::class);
    }

    public function getUpdatedAtAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }

    public function getDetailedLabelAttribute() 
    {   
        $categories = $this->categories->count();
        $items = $this->contentItems->count();
        $label = $this->label;

        return $label.' (cat.: '.$categories.') (items: '.$items.')';
    }
}
