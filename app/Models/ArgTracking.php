<?php

namespace Fsociety\Models;

use Cviebrock\EloquentSluggable\Sluggable;
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
    public function sluggable()
    {
        return [
            'slug' => ['source' => 'name']
        ];
    }

    use Sluggable;

    protected $table = 'arg_tracking';
    protected $fillable = [
        'url', 'description', 'user_id', 'name'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function owns($related, $fk = 'user_id') {
        return $this->id === $related->{$fk};
    }

    // Allow the slug to be the route key name
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
