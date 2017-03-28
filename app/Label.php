<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    public function videos()
    {
        return $this->belongsToMany(Video::class);
    }

    public function scopeFindByName($query, string $name)
    {
        return $query->where('name', $name);
    }

}
