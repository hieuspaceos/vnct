<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon_detail extends Model
{
    use HasFactory;
    protected $table = 'coupon_detail';
    protected $fillable = [
    	'terms_id',
    	'brands_id',
    	'posts_id',
    	'coupons_id'
    	
    ];
}
