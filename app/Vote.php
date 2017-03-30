<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    const VOTE_GOOD = 'good';
    const VOTE_BAD = 'bad';
}
