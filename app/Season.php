<?php

namespace Fsociety;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = [
        'number','tagline'
    ];
    public function episodes() {
        return $this->hasMany(Episode::class);
    }
}
