<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_color_size extends Model
{
    use HasFactory;
    protected $table = 'product_color_size';
    protected $fillable = [
    	'sizes_id',
    	'posts_id',
    	'colors_id',    	
    	'Album',
    	'Soluong'    	
    ];
    public function Color()
    {
    	return $this->belongsTo("App\Models\Color","colors_id");
    }
}
