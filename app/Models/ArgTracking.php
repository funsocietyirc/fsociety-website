<?php

namespace Fsociety\Models;

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
 */
class ArgTracking extends Model
{
    protected $table = 'arg_tracking';
    protected $fillable = [
        'url','description','user_id','name'
    ];

    public function creator() {
        return $this->belongsTo(User::class,'user_id');
    }
}
