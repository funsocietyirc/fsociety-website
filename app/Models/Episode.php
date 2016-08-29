<?php

namespace Fsociety\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

/**
 * Fsociety\Models\Episode
 *
 * @property-read \Fsociety\Models\Season $season
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $season_id
 * @property string $name
 * @property integer $number
 * @property string $airdate
 * @property string $airtime
 * @property string $airstamp
 * @property string $runtime
 * @property string $imageMedium
 * @property string $imageOriginal
 * @property string $summary
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Episode whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Episode whereSeasonId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Episode whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Episode whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Episode whereAirdate($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Episode whereAirtime($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Episode whereAirstamp($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Episode whereRuntime($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Episode whereImageMedium($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Episode whereImageOriginal($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Episode whereSummary($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Episode whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Episode whereUpdatedAt($value)
 */
class Episode extends Model
{
    use Sluggable;
    public function sluggable()
    {
        return [
            'slug' => ['source' => 'name']
        ];
    }

    protected $fillable = [
      'name','number','season_id'
    ];

    public function season() {
        return $this->belongsTo(Season::class);
    }
}
