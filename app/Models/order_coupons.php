<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_coupons extends Model
{
    use HasFactory;
    protected $fillable = [
        'coupons_id',
        'discount',
    		'Code',
    		'Name',
    		'PriceNumber',
    		'PricePercent',
    		'Typediscount',
    		'MaxPricediscount',
    		'NumberOfUse',
            'Status',
    		'StartDay',
    		'EndDay',
            'total_price',
    		'orders_id'  	
    ];
    public function order()
    {
        return $this->hasOne("App\Models\Order");
    }
}
