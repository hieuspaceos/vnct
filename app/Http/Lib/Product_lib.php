<?php

namespace App\Http\Lib;

use App\Models\Posts;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Auth;

use App\Helpers\Helper;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
class Product_lib

{

	public function insert($request)

	{

	//dd($request->input());

		try{

			if($request->input('Post_Name')=='')

			{

				$slug = Str::slug($request->input('Post_Title'),'-');

			}

			else

			{

				$slug =$request->input("Post_Name");

			}

			if (DB::table('posts')->where("Post_Name", $slug)->exists()) {
			    $slug = self::incrementSlug($slug);
			}
    		if(Auth::id())

    		{

    			

				 $post = Posts::Create([	    		

				'users_id'=> Auth::id(),

				

		  		'Post_Title'=>(string) $request->input('Post_Title'),

		  		'Post_Status'=>(integer) $request->input('Post_Status'),

		  		'Post_Name'=>(string) $slug,

		  		'Post_Thumb'=> (string) $request->input('Post_Thumb'),		  		

		  		'Price'=> (float) str_replace(",","",$request->input('Price')),

		  		'Listed_Price'=> (float) str_replace(",","",$request->input('Listed_Price')),

		  		'Sale'=> (integer) str_replace(",","",$request->input('Sale')),

		  		'View'=>0,

		  		'Short_Post_Content'=> (string)(string) $request->input('Short_Post_Content'),

		  		'Post_Content'=>(string) $request->input('Post_Content'),					  				  	

		  		'Post_Sizing'=> (string) $request->input('Post_Sizing'),	

		  		'Title'=>(string) $request->input('Title'),

		  		'Desription'=>(string) $request->input('Desription'),

		  		'Keyword'=>(string) $request->input('Keyword'),

		  		'Post_Type'=>(string) $request->input('Post_Type'),

		  		'lang' => ($request->input('lang')) ? $request->input('lang') : App::currentLocale(),
	  		'origin_id' => ($request->input('origin_id')) ? (int) $request->input('origin_id') : NULL

		  		

				]);

				

				$post->Terms()->attach($request->input('terms_id'));

				if($request->input('color_attr'))

				{

					$color_attr=count($request->input('color_attr'));

					if($color_attr>0)

					{

						for($i=0;$i<$color_attr;$i++)

						{

							if($request->input('album_attr')[$i]!="")

							{

								$array_album = explode(",",  $request->input('album_attr')[$i]);

								foreach ($array_album as $v) {

									Helper::image_size($v);

								}

							}

							$post->Color()->attach($request->input('color_attr')[$i],[

								'sizes_id' => (integer) $request->input('size_attr')[$i],						

								'album' => $request->input('album_attr')[$i],

								'soluong' => (integer) $request->input('soluong_attr')[$i],
								'price' => (integer) $request->input('price_attr')[$i],
								'price_sale' => (integer) $request->input('price_sale_attr')[$i]								

								

							]);

						}

					}

				}

			}

			Session::flash('success', "Thêm thành công");

			

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

		//dd($request);

		try{

			if($request->input('Post_Name')=='')

			{

				$slug = Str::slug($request->input('Post_Title'),'-');

			}

			else

			{

				$slug =$request->input("Post_Name");

			}

			if (DB::table('posts')->where("Post_Name", $slug)->where("id", "<>", $id->id)->exists()) {
			    $slug = self::incrementSlug($slug);
			}

    		$id->Listed_Price = (float) str_replace(",","",$request->input('Listed_Price'));

			$id->Post_Content = (string) $request->input('Post_Content');

			$id->Short_Post_Content = 	(string) $request->input('Short_Post_Content');	

			$id->Post_Sizing = (string) $request->input('Post_Sizing');

			$id->Post_Title = (string) $request->input('Post_Title');

			$id->Post_Status = (integer) $request->input('Post_Status');

			$id->Post_Thumb = (string) $request->input('Post_Thumb');

	  		$id->Post_Name = (string) $slug;	  			  		

	  		$id->Price = (float) str_replace(",","",$request->input('Price'));

	  		$id->Sale = (integer) str_replace(",","",$request->input('Sale'));	  		

	  		$id->Title = $request->input('Title');

	  		$id->Desription = $request->input('Desription');

	  		$id->Keyword  = $request->input('Keyword');	  		

	  		$id->save();

	  		$id->Terms()->detach();

	  		$id->Terms()->attach($request->input('terms_id'));

			

			$id->Color()->detach();

			if($request->input('color_attr'))

			{

			$color_attr=count($request->input('color_attr'));

			

			if($color_attr>0)

			{

				for($i=0;$i<$color_attr;$i++)

				{

					$array_album = explode(",",  $request->input('album_attr')[$i]);

					foreach ($array_album as $v) {

						if($v!="")

						{

						Helper::image_size($v);

						}

					}

					$id->Color()->attach($request->input('color_attr')[$i],[

						'sizes_id' => $request->input('size_attr')[$i],						

						'album' => $request->input('album_attr')[$i],

						'soluong' => $request->input('soluong_attr')[$i],
						'price' => (integer) $request->input('price_attr')[$i],
								'price_sale' => (integer) $request->input('price_sale_attr')[$i]													

					]);

				}

			}

			}

			Session::flash('success', "Sữa thành công");

		}

		catch(\Exception $err)

		{

			Session::flash('error', $err->getMessage());

			return false;

		}

		return true;

	}

	public static function incrementSlug($slug,$id="") {

	    $original = $slug;

	    $count = 1;

	   	while (DB::table('posts')->where("Post_Name", $slug)->exists()) {

		        $slug = "{$original}-" . $count++;

		 }		

	    return $slug;

	}

}

?>