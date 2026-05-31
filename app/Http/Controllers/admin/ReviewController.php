<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReviewProduct;
class ReviewController extends Controller
{
    public function Review_list()
    {
    	$list = ReviewProduct::with('product')->get(); 
    	//dd($list->toarray());   	
    	return view('admin.page.review_list',[
    		"allPosts" => $list,
    		"title" => "List Review"
    	]);
    }
    public function Review_update(Request $request)
    {
    	$review = ReviewProduct::find($request->id);
    	
    	if($request->check==1)
    	{
    			
    		$review->status = 1;
    	}
    	else
    	{

    		$review->status = 0;
    	}
    	$review->save();
    	return array(
    		"success"=>true,
    	);
    	
    }
    public function Review_delete(ReviewProduct $id)
    {
        $id->delete();
        return redirect()->back();
    }
}
