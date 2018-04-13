<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $code
 * @property string $code_alpha3
 * @property string $fips_code
 * @property string $name
 * @property string $currency
 * @property int $dialcode
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereCodeAlpha3($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereCurrency($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereDialcode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereFipsCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Country extends Model
{
    //
}
