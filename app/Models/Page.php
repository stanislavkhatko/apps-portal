<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * App\Page
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property mixed $title
 * @property mixed $body
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page whereTitle($value)
 * @property int $content_portal_id
 * @property-read \App\Models\ContentPortal $contentPortal
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page whereContentPortalId($value)
 */
class Page extends Model
{
    use HasTranslations;

    protected $guarded = [];

    protected $casts = ['visible' => 'boolean'];

    //public $translatable = ['title', 'body'];

    protected $fillable = ['content_portal_id', 'lang_code', 'title', 'body', 'type', 'visible', 'position'];

    public function contentPortal()
    {
        return $this->belongsTo(ContentPortal::class);
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
