<?php

namespace App\Models;

use App\Scopes\AdultScope;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\ContentItem
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $remote_id
 * @property int $category_id
 * @property string $title
 * @property string $content_artist
 * @property mixed $description
 * @property mixed $preview
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentItem whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentItem whereContentArtist($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentItem whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentItem whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentItem wherePreview($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentItem whereRemoteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentItem whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentItem whereUpdatedAt($value)
 * @property mixed $info
 * @property array $compatibility
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentItem whereCompatibility($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentItem whereInfo($value)
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ContentDownload[] $downloads
 */
class ContentItem extends Model
{
    use HasTranslations;

    protected $guarded = [];
    protected $translatable = ['title', 'description'];
    protected $casts = ['compatibility' => 'array', 'download' => 'array', 'is_customized' => 'boolean'];
    protected $appends = ['titleTranslated'];
    protected $fillable = ['category_id', 'provider', 'type', 'title', 'description', 'compatibility', 'preview', 'remote_id', 'download', 'is_customized'];

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

    public function getPreviewAttribute($value)
    {
        if (Storage::disk('spaces')->exists($value)) {
            return Storage::disk('spaces')->url($value);
        }
        return $value;
    }

    public function setPreviewAttribute($value)
    {
        if ($value && strstr($value, '.com/')) {
            return substr($value, strpos($value, '.com/') + 5);
        }

        return $value;
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
