<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    protected $fillable = ['user_id', 'category_id', 'question_id', 'true_ans', 'user_ans', 'point', 'coin', 'status'];
}
