<?php

namespace Fsociety;

use Illuminate\Database\Eloquent\Model;

class ArgTracking extends Model
{
    protected $fillable = [
        'url','description','user_id','season_mentioned_id','episode_mentioned_id'
    ];
}
