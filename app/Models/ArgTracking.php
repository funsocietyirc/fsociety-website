<?php

namespace Fsociety\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use DB;
use Illuminate\Database\Eloquent\Model;

/**
 * Fsociety\Models\ArgTracking
 *
 * @property-read \Fsociety\Models\User $creator
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $user_id
 * @property string $url
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\ArgTracking whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\ArgTracking whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\ArgTracking whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\ArgTracking whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\ArgTracking whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\ArgTracking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\ArgTracking whereName($value)
 * @property string $slug
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\ArgTracking whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\ArgTracking findSimilarSlugs($model, $attribute, $config, $slug)
 */
class ArgTracking extends Model
{
    protected $table = 'arg_tracking';

    use Sluggable;
    protected $fillable = [
        'url',
        'description',
        'user_id',
        'name'
    ];

    public function sluggable()
    {
        return [
            'slug' => ['source' => 'name']
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Arg Link tracking connections

    /**
     * Get the available ARG collections
     */
    public function availableConnections()
    {
        return DB::table('episodes')
            ->select([
                'name',
                'id'
            ])->whereNotIn('id',
                DB::table('arg_season_episode')
                    ->where('arg_id', $this->id)
                    ->pluck('episode_id')
            )->get();
    }

    public function inSeasons()
    {
        return $this->connections()
            ->get()
            ->unique(function ($x) {
                return $x->episode->season_id;
            })
            ->sortBy(function ($x) {
                return $x->episode->season_id;
            });
    }

    public function connections()
    {
        return $this->hasMany(ArgSeasonEpisode::class, 'arg_id', 'id');
    }

    public function inEpisodes()
    {
        return $this->connections()
            ->get()
            ->unique(function ($x) {
                return $x->episode->number;
            })
            ->SortBy(function ($x) {
                return $x->episode->number;
            });
    }

    // Allow the slug to be the route key name
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
