<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    protected $fillable = [
        'player_name',
        'a',
        'b',
        'correct_gcd',
        'answer',
        'is_correct',
    ];
}