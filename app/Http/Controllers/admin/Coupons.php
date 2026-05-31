<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Http\Lib\Coupon_lib;
use App\Models\Terms;
use App\Models\Posts;
use App\Models\Brand;
class Coupons extends Controller
{
   protected $coupon_lib;
	public function __construct(Coupon_lib $coupon_lib)
	{
		$this->coupon_lib = $coupon_lib;
	}
	public function coupon_list()
    {
        $allPosts = Coupon::all();
    	return view('admin.page.coupon_list',[
                "title"=>"Danh sách Cuopon",
               "allPosts"=>$allPosts
        ]);
    }
    public function coupon_add()
    {                   
    	return view('admin.page.coupon_add',[
                "title"=>"Thêm Cuopon",
               
        ]);
    }
    public function coupon_add_store(Request $request)
    {
    	//dd($request->input());
        $this->coupon_lib->insert($request);        
        return redirect()->back();
    }
    public function coupon_edit(Coupon $id)
    {
        return view('admin.page.coupon_edit',[
            "coupon" =>$id,
            "title" => "Sữa coupon ".$id->Name,          
        ]);
        //dd($danhmuc->toArray());
    }
    public function coupon_edit_store(Coupon $id, Request $request)
    {
    	$this->coupon_lib->update($request,$id);
        return redirect()->route('coupon');
    }
    public function coupon_delete($id)
    {
       
        Coupon::destroy($id);
        return redirect()->back();
    }
    public function update_usepopup(Request $request)
    {
         Coupon::query()->update(["UsePopup"=>0]);
         Coupon::find($request->id)->update(["UsePopup"=>1]);
         return array(
            "success"=>true
         );
    }
}
