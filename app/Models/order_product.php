<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_product extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "order_product";
    protected $fillable = [
    	"Product_title",
    	"Soluong",
    	"Price",
    	"Sale",
    	"Image",
    	"Color",
    	"Size",
    	"curent_price",
        "sub_total",
        "order_coupons_products_id"
    ];
    public function order_product_coupons()
    {
        return $this->hasOne("App\Models\Order_product_coupons");
    }
}
