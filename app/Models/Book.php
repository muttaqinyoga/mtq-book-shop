<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $incrementing = false;

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
