<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class terms_posts extends Model
{
    use HasFactory;
    protected $fillable = [
  		'posts_id',
  		'terms_id'  	
  	];
  	public function Posts()
    {
        return $this->belongsTo('App\Models\Posts','posts_id');
    }
}
