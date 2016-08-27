<?php

namespace Fsociety;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $fillable = [
      'name','number','season_id'
    ];
}
