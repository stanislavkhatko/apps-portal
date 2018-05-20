<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * App\ContentPortal
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property array $disclaimer
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\ContentPortal whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ContentPortal whereDisclaimer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ContentPortal whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ContentPortal whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ContentPortal whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ContentPortal whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $host
 * @property string $domain
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentPortal findSimilarSlugs(\Illuminate\Database\Eloquent\Model $model, $attribute, $config, $slug)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentPortal whereDomain($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentPortal whereHost($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ContentType[] $contentTypes
 * @property array $languages
 * @property string $brand
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ContentItem[] $featuredItems
 * @property-read \App\Models\Page $homePage
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Page[] $pages
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentPortal whereBrand($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentPortal whereLanguages($value)
 */
class ContentPortal extends Model
{
    use HasTranslations, Sluggable;

    protected $guarded = [];

    protected $translatable = ['disclaimer'];

    protected $casts = [
        'languages' => 'array',
        'config' => 'array',
        'options' => 'array'
    ];

    protected $with = ['featuredItems', 'localContentTypes', 'pages'];

    protected $fillable = ['title', 'subdomain', 'host', 'domain', 'default_language', 'languages', 'offer_url', 'exit_url', 'options'];

    public function sluggable()
    {
        return [
            'slug' => [
                'onUpdate' => true,
                'unique' => false,
                'source' => 'subdomain'
            ]
        ];
    }

    public function theme()
    {
        return $this->belongsTo(ContentPortalTheme::class, 'content_portal_theme_id');
    }

    public function localContentTypes()
    {
        return $this->belongsToMany(LocalContentType::class);
    }

    public function getContentItemsAttribute()
    {
        return $this->localContentTypes->pluck('contentItems')->collapse()->values();
    }

    public function featuredItems()
    {
        return $this->belongsToMany(ContentItem::class, 'featured_items')->withPivot('banner', 'visible');
    }

    public function activeFeaturedItems()
    {
        return $this->belongsToMany(ContentItem::class, 'featured_items')->wherePivot('visible', 1)->withPivot('banner', 'visible');
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function dynamicPages()
    {
        return $this->hasMany(Page::class)->where('type', 'dynamic')->where('visible', '1')->orderBy('position', 'ASC');
    }

    public function disclaimers()
    {
        return $this->hasMany(Page::class)->where('type', 'disclaimer')->where('visible', '1');
    }

    public function priceBanners()
    {
        return $this->hasMany(Page::class)->where('type', 'price-banner')->where('visible', '1');
    }

    public function newsSliders()
    {
        return $this->hasMany(Page::class)->where('type', 'slider')->where('visible', '1');
    }

    public function homePage()
    {
        return $this->hasOne(Page::class)->where('title', 'home');
    }

    public function getCreatedAtAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }

    public function getCountryIcon($value)
    {
        $iconLang = $value;

        if ($value == 'en') $iconLang = 'gb';
        if ($value == 'el') $iconLang = 'gr';
        if ($value == 'sr') $iconLang = 'rs';
        if ($value == 'uk') $iconLang = 'ua';

        return $iconLang;
    }

}
