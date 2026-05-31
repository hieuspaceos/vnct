<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    //

    public function show()
    {
    	$list = Order::with("order_coupons_product")->with("users")->get();
    	return view("page.bill",["allPosts" => $list]);
    }
    public function seen(Order $id)
    {    	
    	$list = $id::with("order_coupons_product")->with("order_coupons")->with("order_product")->with("users")->where('id',$id->id)->where("users_id",Auth::user()->id)->get();
    	if($list->count() > 0)
    	{

    		return view("page.bill_xem",["Post" => $list]);
    	}
    	else
    	{    		
    		return redirect()>back();
    	}
    	
    }
}
