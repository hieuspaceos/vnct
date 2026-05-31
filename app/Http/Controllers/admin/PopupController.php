<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PopupListBuy;
use Illuminate\Support\Facades\Session;
class PopupController extends Controller
{
   public function popup_list()
    {
    	$list = PopupListBuy::all();
    	//dd($list->toArray());
    	return view('admin.page.popup_list',[
    		"list" => $list,
    		"title" => "Danh sách popup"
    	]);
    }
    public function popup_add()
    {
    	 
    	return view('admin.page.popup_add',[    		
    		"title" => "Thêm popup"
    		
    	]);
    }
    public function popup_add_store(Request $request)
    {
    	
    	//dd($request->input());
    		$faq = PopupListBuy::Create([
    			"posts_id"=>  $request->input('posts_id'),
    			"colors_id"=> $request->input('colors_id'),
    			"Content" =>  $request->input('Content')
    		]);    		    	
    		Session::flash('success', "Thêm thành công");
    		return redirect()->route('popup_list');

    	
    }
    public function popup_edit(PopupListBuy $id)
    {    	    	        	 
    	return view('admin.page.popup_edit',[
    		"Post" => $id,
    		"title" => "Edit popup",    		
    	]);
    }
    public function popup_edit_store(PopupListBuy $id, Request $request)
    {    	
    	try{
    		$id->posts_id = $request->input('posts_id');
    		$id->colors_id =  $request->input('colors_id');
    		$id->Content =  $request->input('Content');
    		$id->save();    		
    		Session::flash('success', "Cập nhật thành công");
    		return redirect()->route('popup_list');
    	}
    	catch(\Exception $err)
		{
			Session::flash('error', $err->getMessage());
			return redirect()->back();
		}
    }
    public function popup_delete(PopupListBuy $id)
    {    	
    	$id->delete();
    	return redirect()->back();
    }
}
