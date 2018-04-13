<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContentDownload
 *
 * @property int $id
 * @property string $msisdn
 * @property int $subscription_id
 * @property int $content_item_id
 * @property mixed $item
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\ContentItem $contentItem
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentDownload whereContentItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentDownload whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentDownload whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentDownload whereItem($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentDownload whereMsisdn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentDownload whereSubscriptionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentDownload whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContentDownload extends Model
{
    protected $guarded = [];
    protected $casts = [
        'item' => 'array',
    ];

    public function contentItem()
    {
        return $this->belongsTo(ContentItem::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }
}
