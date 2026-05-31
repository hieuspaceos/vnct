<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Coupons_Product extends Model
{
    use HasFactory;
     public $timestamps = false;
     protected $table = 'order_coupons_products';    
    protected $fillable = [
    	'product_id',
    	'coupons_id',
        'discount',
    		'Code',
    		'Name',
    		'PriceNumber',
    		'PricePercent',
    		'Typediscount',
    		'MaxPricediscount',
    		'NumberOfUse',
    		'MinPriceuse',
            'Status',
    		'StartDay',
    		'EndDay' ,
            'orders_id'   		
    ];
    public function order()
    {
        return $this->hasOne("App\Models\Order");
    }
}
