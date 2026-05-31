<?php
namespace App\Http\Lib;
use App\Models\Terms;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
class Terms_lib
{
	public function insert($request)
	{
		//dd($request->input());
		try{
			if($request->input('slug')=='')
			{
				$slug = Str::slug($request->input('TenLoai'),'-');
			}
			else
			{
				$slug =$request->input("slug");
			}
			if (Terms::withoutGlobalScopes()->where("Slug", $slug)->exists()) {
			    $slug = self::incrementSlug($slug);
			}
    		

			Terms::Create([
			'Name'=>(string) $request->input('TenLoai'),
	  		'Slug'=>(string) $slug,
	  		'Image'=> $request->input('Hinh'),
	  		'Taxonomy'=>$request->input('type'),
	  		'Parent'=>$request->input('idParent'),
	  		'Title'=>$request->input('Title'),
	  		'Description'=>$request->input('Description'),
	  		'keyword'=>$request->input('Keywords'),
	  		'Content'=>($request->input('Content')) ? $request->input('Content'): '',
	  		'vitri'=>($request->input('Vitri')) ? $request->input('Vitri'): 0,
	  		'ThuTu'=>0,
	  		'AnHien'=>$request->input('AnHien'),
	  		'lang' => ($request->input('lang')) ? $request->input('lang') : App::currentLocale(),
	  		'origin_id' => ($request->input('origin_id')) ? (int) $request->input('origin_id') : NULL
			]);
			Session::flash('success', "Tạo danh mục thành công");
		}
		catch(\Exception $err)
		{
			Session::flash('error', $err->getMessage());
			return false;
		}
		return true;
	}	
	public function update($request,$id)
	{
		//dd($request->input());
		try{
			if($request->input('slug')=='')
			{
				$slug = Str::slug($request->input('TenLoai'),'-');
			}
			else
			{
				$slug =$request->input("slug");
			}
			if (Terms::withoutGlobalScopes()->where("Slug", $slug)->where("id", "<>", $id->id)->exists()) {
			    $slug = self::incrementSlug($slug);
			}
			$id->Name = (string) $request->input('TenLoai');
	  		$id->Slug = (string) $slug;
	  		$id->Image = $request->input('Hinh');
	  		$id->Taxonomy= $request->input('type');
	  		$id->Parent = $request->input('idParent');
	  		$id->Title = $request->input('Title');
	  		$id->Description = $request->input('Description');
	  		$id->keyword  = $request->input('Keywords');
	  		$id->Content = ($request->input('Content')) ? $request->input('Content'): '';
	  		$id->vitri = ($request->input('Vitri')) ? $request->input('Vitri'): 0;
	  		$id->AnHien = $request->input('AnHien');
	  		$id->save();
			
			Session::flash('success', "Sữa danh mục thành công");
		}
		catch(\Exception $err)
		{
			Session::flash('error', $err->getMessage());
			return false;
		}
		return true;
	}
	public static function incrementSlug($slug) {
	    $original = $slug;
	    $count = 1;
	   while (Terms::withoutGlobalScopes()->where("Slug", $slug)->exists()) {
		    $slug = "{$original}-" . $count++;
		}
	    return $slug;
	}
}
?>