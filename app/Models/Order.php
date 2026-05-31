<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
    	"CodeOrder",
    	"Total",
    	"users_id",
        "Note",
        'status',
        'ship',
    ];
    public function order_coupons_product()
    {
    	return $this->hasMany("App\Models\Order_Coupons_Product",'orders_id');
    }
    public function users()
    {
        return $this->belongsTo("App\Models\User");
    }
    public function order_coupons()
    {
        return $this->hasOne("App\Models\order_coupons","orders_id");
    }
    public function order_product()
    {
        return $this->hasManyThrough("App\Models\order_product","App\Models\Order_Coupons_Product",
            "orders_id",
            "order_coupons_products_id",
            "id",
            "id");
    }
}
