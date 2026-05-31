<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Faq_Answer;
use Illuminate\Support\Facades\Session;
use App\Models\Terms;
class FaqController extends Controller
{
    public function faq_list()
    {
    	$list = Faq::with('Terms')->get();
    	//dd($list->toArray());
    	return view('admin.page.faq_list',[
    		"allPosts" => $list,
    		"title" => "Danh sách faq"
    	]);
    }
    public function faq_add()
    {
    	 $allMenus = Terms::where("Taxonomy","faq")->where('AnHien',1)->get(); 
    	return view('admin.page.faq_add',[    		
    		"title" => "Thêm faq",
    		"allMenus"=>$allMenus
    	]);
    }
    public function faq_add_store(Request $request)
    {
    	
    	
    		$faq = Faq::Create([
    			"Title"=>  $request->input('Title'),
    			"terms_id"=> (integer) $request->input('terms_id'),
    			"lang" => (integer) $request->input('language')
    		]);
    		if($request->input('question'))
    		{
	    		foreach ($request->input('question') as $key => $value) {
	    			Faq_Answer::Create([
		    			"Question" => $value,
		    			"Answer" => $request->input('answer')[$key],
		    			"faqs_id" => $faq->id
	    			]);
	    		}
    		}
    		//dd($request->input());
    		Session::flash('success', "Thêm thành công");
    		return redirect()->route('faq_list');

    	
    }
    public function faq_edit(Faq $id)
    {    	    	    
    	 $allMenus = Terms::where("Taxonomy","faq")->where('AnHien',1)->get(); 
    	return view('admin.page.faq_edit',[
    		"Post" => $id,
    		"title" => "Edit ".$id->Title,
    		"allMenus"=>$allMenus
    	]);
    }
    public function faq_edit_store(Faq $id, Request $request)
    {    	
    	try{
    		$id->Title = $request->input('Title');
    		$id->terms_id = (integer) $request->input('terms_id');
    		$id->save();
    		$id->Faq_Answer()->delete();
    		if($request->input('question'))
    		{
	    		foreach ($request->input('question') as $key => $value) {
	    			Faq_Answer::Create([
		    			"Question" => $value,
		    			"Answer" => $request->input('answer')[$key],
		    			"faqs_id" => $id->id
	    			]);
	    		}
    		}
    		Session::flash('success', "Cập nhật thành công");
    		return redirect()->route('faq_list');
    	}
    	catch(\Exception $err)
		{
			Session::flash('error', $err->getMessage());
			return redirect()->back();
		}
    }
    public function faq_delete(Faq $id)
    {
    	$id->Faq_Answer()->delete();
    	$id->delete();
    	return redirect()->back();
    }
    public function faq_update_order( Request $request)
    {
        Faq::find($request->id)->update(["thutu"=>$request->so]);
        return array(
            "success" => true
        );
    }
}
