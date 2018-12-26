<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title', 'category_id', 'ans1', 'ans2', 'ans3', 'ans4', 'ans5', 'true_ans', 'time_limit', 'point', 'coin', 'status'];
}
