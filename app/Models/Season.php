<?php

namespace Fsociety\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Fsociety\Models\Season
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fsociety\Models\Episode[] $episodes
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $number
 * @property string $tagline
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Season whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Season whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Season whereTagline($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Season whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Season whereUpdatedAt($value)
 */
class Season extends Model
{
    protected $fillable = [
        'number','tagline'
    ];
    public function episodes() {
        return $this->hasMany(Episode::class);
    }
}
