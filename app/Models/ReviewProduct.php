<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewProduct extends Model
{
    use HasFactory;
     protected $fillable = [
    	'Image',
    	'Name',
    	'Start',
    	'Content',
        'colors_id',
    	'posts_id',
    	'users_id'
    ];
     public function product()
    {
        return $this->belongsTo("App\Models\Posts","posts_id");
    }
}
