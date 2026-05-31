<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    public $timestamps = false;
     protected $fillable = [
    		'Name'
    		
    ];
     public function Posts()
    {
        return $this->belongsToMany('App\Models\Posts','product_color_size','sizes_id','posts_id')
        ->withPivot('colors_id','album','soluong','price','price_sale');
    }
    public function Color()
    {
        return $this->belongsToMany('App\Models\Color','product_color_size','sizes_id','colors_id')
        ->withPivot('posts_id','album','soluong','price','price_sale');
    }
}
