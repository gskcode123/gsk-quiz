<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    protected $fillable = ['user_id', 'category_id', 'question_id', 'is_correct', 'given_answer', 'point', 'coin', 'status'];
}
