<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
     public $timestamps = false;
     protected $fillable = [
    		'Name',
    		'Ma_Mau'
    		
    ];
   public function Posts()
    {
        return $this->belongsToMany('App\Models\Posts','product_color_size','colors_id','posts_id')
        ->withPivot('sizes_id','album','soluong','price','price_sale');
    }
    public function Size()
    {
        return $this->belongsToMany('App\Models\Size','product_color_size','colors_id','sizes_id')
        ->withPivot('posts_id','album','soluong','price','price_sale');
    }
}
