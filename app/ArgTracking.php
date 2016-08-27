<?php

namespace Fsociety;

use Illuminate\Database\Eloquent\Model;

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
