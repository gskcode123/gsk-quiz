<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title', 'category_id', 'serial', 'image', 'type', 'answer', 'time_limit', 'point', 'coin', 'status'];
}
