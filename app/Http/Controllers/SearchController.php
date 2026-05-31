<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\product_color_size;
class SearchController extends Controller
{
     public function search_ajax(Request $request)
   {
       /* $posts = Posts::select(['id','Post_Title as value','Price','Sale','Post_Name'])->where('Post_Title', 'LIKE', "%$request->search_complete%")->with("Color")->get();*/
        //dd($posts->toarray());
       $b = Posts::select(['id','Post_Title as value','Price','Sale','Post_Name'])->where('Post_Title', 'LIKE', "%$request->search_complete%")->limit(10)->get();
       $item = [];
       $dem = 0;
       foreach ($b as $key => $v) {

          $color = product_color_size::where("posts_id",$v->id)->groupBy('colors_id')->get();
         
          foreach ($color as $key => $c) {
                $dem++;              
              array_push($item,
                [
                    "id"=>$v->id,
                    "value"=>$v->value." - ".$c->color->Name,
                    "Price"=>$v->Price,
                    "Sale"=>$v->Sale,
                    "Post_Name"=> $v->Post_Name,
                    "color" => $c->colors_id,
                    "image" => $c->Album
                ]
              );
           } 
          
                  
       }
        return array(
            "success"=>true,
            'posts' => $item
        );
   }
   public function search($key)
   {
   		
   	    $productshow =24;
        
       $posts = Posts::where('Post_Title', 'LIKE', "%$key%")
				       ->paginate($productshow);
   		return view('page.search',[
   			 "page"=>"search",
   			"title" => "Tìm kiếm",
   			"posts"=>$posts,
   			"key"=>	$key
   		]);
   }
}
