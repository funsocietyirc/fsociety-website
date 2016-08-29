<?php

namespace Fsociety\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
 */
class User extends Authenticatable
{
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

    public function argLinks() {
        return $this->hasMany(ArgTracking::class);
    }
}
