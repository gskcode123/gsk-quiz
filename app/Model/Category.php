<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'image', 'qs_limit', 'time_limit', 'max_limit', 'serial', 'status'];

    public function question()
    {
        return $this->hasMany(Question::class);
    }
}
