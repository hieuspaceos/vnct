<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Posts;
use App\Http\Lib\Order_lib;
use App\Models\order_product;
use App\Models\Order_Coupons_Product;
class Donhang extends Controller
{
	protected $order_lib;
	public function __construct(Order_lib $orderlib)
	{
		$this->order_lib = $orderlib;
	}
    public function donhang_list()
    {
    	$list = Order::with("order_coupons_product")->with("users")->get();
    	//dd($list->toArray());
    	return view('admin.page.donhang_list',[
    		"allPosts" => $list,
    		"title" => "Danh sách đơn hàng"
    	]);
    }
    public function donhang_add()
    {
    	
    }
    public function donhang_add_store(Request $request)
    {
    	
    }
    public function donhang_edit(Order $id)
    {
    	$id_ = $id->id;	
    	$list = $id::with("order_product")->with("users")->where('id',$id->id)->get();
    	//dd($list->toArray());
    	return view('admin.page.donhang_edit',[
    		"Post" => $list,
    		"title" => "Danh sách đơn hàng"
    	]);
    }
    public function donhang_edit_store(Order $id, Request $request)
    {
    	//dd($id->users->name);
    	$this->order_lib->update($id, $request);
    	return redirect()->route('donhang');
    }
    public function donhang_delete(Order $id)
    {
        $id->order_product()->delete();
        $id->order_coupons_product()->delete();
        $id->delete();
        return redirect()->back();
    }
}
