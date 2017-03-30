<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function addLabel(Label $label)
    {
        $this->labels()->save($label);
        $this->save();
    }

    public function addVote(Vote $vote)
    {
        $this->votes()->save($vote);
    }
}
