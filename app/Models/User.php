<?php

namespace Fsociety\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Silber\Bouncer\Database\HasRolesAndAbilities;

/**
 * Fsociety\Models\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fsociety\Models\ArgTracking[] $argLinks
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $unreadNotifications
 * @mixin \Eloquent
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\User whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\Silber\Bouncer\Database\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\Silber\Bouncer\Database\Ability[] $abilities
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\User whereIs($role)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\User whereIsAll($role)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\User whereCan($ability, $model = null)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\User whereCannot($ability, $model = null)
 */
class User extends Authenticatable
{
    use HasRolesAndAbilities;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function argLinks()
    {
        return $this->hasMany(ArgTracking::class);
    }

    public function owns($related, $fk = 'user_id')
    {
        return $this->id === $related->{$fk};
    }

}
