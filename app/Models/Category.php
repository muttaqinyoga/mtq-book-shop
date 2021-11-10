<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $incrementing = false;

    public function book()
    {
        return $this->belongsToMany(Book::class);
    }
}
