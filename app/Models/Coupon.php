<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
    		'Code',
    		'Name',
    		'PriceNumber',
    		'PricePercent',
    		'Typediscount',
    		'MaxPricediscount',
    		'NumberOfUse',           
            'Status',
            'UsePopup',
    		'StartDay',
    		'EndDay'    	
    ];
    public function terms()
    {
        return  $this->belongsToMany('App\Models\Terms','coupon_detail','coupons_id','terms_id');
    }
    public function brands()
    {
        return  $this->belongsToMany('App\Models\Brand','coupon_detail','coupons_id','brands_id');
    }
    public function posts()
    {
        return  $this->belongsToMany('App\Models\Posts','coupon_detail','coupons_id','posts_id');
    }
}
