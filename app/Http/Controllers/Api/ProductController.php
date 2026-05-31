<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Posts;
use App\Models\Config;
use App\Models\Terms;
use App\Models\Color;
use App\Models\Size;
use App\Helpers\FrontEnd;
use App\Helpers\Helper;
use App\Models\product_color_size;
use DB;
use Illuminate\Support\Facades\Cache;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail(Posts $id)
    {      
       // dd($id->toArray());
        $post = array(); 
        $json_data = array(); 
        $dem2=0;
                   
                       array_push($post,$id->toArray()); 
                       $id_color = product_color_size::select('colors_id','Album')->where('posts_id',(int)$id->id)->groupBy('colors_id')->get();                       
                     
                       $demcolor = 0;
                      //  dd($id_color);
                      
                        $dem = 0;
                       foreach($id_color as $v2)
                       {                         
                        $post[0]["Color"][$dem] = Color::find($v2->colors_id)->toArray() ;
                        $post[0]["Color"][$dem]["album"] = $v2->Album;
                        $id_size = product_color_size::select(DB::raw("group_concat(Distinct sizes_id SEPARATOR ',') as ID"))->where('posts_id',(int)$id->id)->where('colors_id',$v2->colors_id)->get();
                            $array_id_size = explode(",",$id_size[0]->ID);
                            $demsize = 0;
                            foreach($array_id_size as $idsize)
                            {
                                $post[0]["Color"][$dem]["Size"][$demsize] = Size::find($idsize)->toArray();
                                $demsize++; 
                            }
                        $dem++;
                        
                                                 
                       }
                      
                   
                    $a = [];
                   
                    $a["data"]  = $post  ;  
                   
                    array_push($json_data,$a);
                    return Response()->json($json_data);                    
    }
    public function index()
    {
        //Cache::flush();
        if (Cache::has('index')) {
            return Response()->json(Cache::get('index'));            
        }
        else
        {
        $config = Config::all()->toArray();            
        $b = explode(",",$config[8]["Value"]); 
        $json_data = array();
        $dem = 0;
        foreach($b as $v)
        {
           $dem++;
           if($dem%2==0)
            {
                $bg = 'background:#f2f2f2;';
            }
            else
            {
                $bg = 'background:#fff;';

			}
            $danhmuc = Terms::find($v);	 
            $data = array();           
            if($danhmuc->Taxonomy=="sanpham")        
            {        
                    $array_child_id = Helper::user_all_childs_ids($danhmuc);  
                        
                    array_push($array_child_id,$v);
                   // dd(Posts::find(3)->Color()->get()->toArray());        
                    $post = Posts::Wherehas('Terms',function($query) use($array_child_id){        
                        $query->whereIn("id",$array_child_id);        
                    })->where('Post_Status',1)->orderByDesc('created_at')->skip(0)->take(20)->get();
                   $dem2=0;
                  
                    // foreach($post as $vpost)
                    // {
                    //      array_push($data,$vpost->toArray()); 
                    //    $id_color = product_color_size::select('colors_id','Album')->where('posts_id',(int)$vpost->id)->groupBy('colors_id')->get();                       
                    //    $dem3 = 0;
                    //    //dd($id_color);
                    //    foreach($id_color as $v2)
                    //    { 
                       
                    //         $a = array();                           
                    //        $data[$dem2]["Color"][$dem3]= Color::find($v2->colors_id)->toArray()  ;
                    //         $data[$dem2]["Color"][$dem3]["Album"]= $v2->Album;                          
                    //         $dem3++;                                                                        
                    //    }


                    //    $dem2++;
                    // }
                    $data = array();     
                   foreach($post as $vpost)
                    {
                         array_push($data,$vpost->toArray()); 
                       $id_color = product_color_size::select('colors_id','Album')->where('posts_id',(int)$vpost->id)->groupBy('colors_id')->get();                       
                       $dem3 = 0;
                       //dd($id_color);
                       foreach($id_color as $v2)
                       { 
                       
                            $a = array();                           
                           $data[$dem2]["Color"][$dem3]= Color::find($v2->colors_id)->toArray()  ;
                            $data[$dem2]["Color"][$dem3]["album"]= $v2->Album;   
                             $id_size = product_color_size::select(DB::raw("group_concat(Distinct sizes_id SEPARATOR ',') as ID"))->where('posts_id',(int)$vpost->id)->where('colors_id',$v2->colors_id)->get();
                            $array_id_size = explode(",",$id_size[0]->ID);
                            $demsize = 0;
                            foreach($array_id_size as $idsize)
                            {
                                $data[$dem2]["Color"][$dem3]["Size"][$demsize] = Size::find($idsize)->toArray();
                                $demsize++; 
                            }
                                            
                            $dem3++;                                                                        
                       }


                       $dem2++;
                    }
                   //dd($data );
                    $a = [];
                    $a["tieude"] = $danhmuc->Name; 
                    $a["data"]  =$data  ;  
                   
                    array_push($json_data,$a);
            }
            if($danhmuc->Taxonomy=="page")
            { 
              
               // $post = Posts::where('Post_Status',1)->orderByDesc('created_at')->limit(10)->get();
               
                //  $content = str_replace("{newin}",FrontEnd::get_new_product($danhmuc,$bg,$post,$v), $danhmuc->Content);
                // $a = [];
                // $a["tieude"] = $danhmuc->Name; 
                // $a["data"]  = array($danhmuc->toArray()); 
                // array_push($json_data,$a);
            }     
        }
       
      // dd($json_data);
       // return '[{"tieude":"New In","data":""},{"tieude":"Home 1","data":""},{"tieude":"Home 2","data":""},{"tieude":"Clothing","data":""},{"tieude":"Tops","data":""}]';
        // $a = [
        //     array("success"=>1,"tieude"=>"abc"),
        //     array("success"=>1,"tieude"=>"abc")
        // ];
       // dd($json_data) ;
        Cache::put('index', $json_data, 86400);
        return Response()->json($json_data);
        }
    }

    public function slide()
    {
        $config = Config::all()->toArray();
       // echo $config[5]["Value"];
       $slide = json_decode($config[5]["Value"]);
       $dem = 0;
       $dem2 = 0;
       $array = array();
       foreach($slide as $v)
       {
           $dem++;
           if($dem==1)
           {
               if($v==null)
               {
                $v = "a";
               }
            $array[$dem2]["url"] =  $v; 
           }
           if($dem==2)
           {
            $array[$dem2]["image"] =  $v; 
           }
           if($dem%2==0)
           {
               $dem = 0;
                $dem2++;
           }          
       }
       
        return Response()->json($array);
    }
    public function getallcate()
    {
         $config = Config::all()->toArray();         
          return Response()->json(json_decode($config[4]["Value"]));
    }
    public function getcatedetail(Terms $terms,Request $request)
    {
        //dd($terms);
         $jsondata = array();
       
        $jsondata["tieude"] = $terms->Name;
        $cate = $terms;
       
         $config = Config::all()->toArray();        
        $title = $terms->Name; 
        $id  =    $terms->id;        
        $bradcrumb = Helper::get_all_parent_by_id($terms);
        $sub_cate = $terms->childs;
        $showall = $terms; 
        //dd($sub_cate->count());      
        if($sub_cate->count()==0 && $terms->Parent > 0)
        {
            $sub_cate = $terms->parents->first();
            $showall = $sub_cate;
            //dd($sub_cate->toarray());
             $sub_cate = Terms::where("Slug",$sub_cate->Slug)->get()->first(); 
            $sub_cate = $sub_cate->childs;
        }
        $array_child_id = Helper::user_all_childs_ids($terms);

        array_push($array_child_id,$terms->id);

        $from = $to =  0; 
        $color =  collect();
        $size =   collect();         
        if($request->input("price"))
        {            
            $price = explode(",",$request->input("price"));   
            $from = (int)$price[0];
            $to = (int)$price[1];
        }       
        if($request->input("colors"))
        {
            $mau = explode(",",$request->input("colors"));
            foreach ($mau as $key => $value) {                              
                $ex = (int)$value; 
                $color->push($ex);
            }

           //$color =$request->input("colors");
        } 
        if($request->input("sizes"))
        {
             $kichtuoc = explode(",",$request->input("sizes"));
            foreach ($kichtuoc as $key => $value) {                              
                $ex = (int)$value; 
                $size->push($ex);
            }            
        } 




        //dd($from."-".$to."-".$color."-".$size);
        $post = Posts::Wherehas('Terms',function($query) use($array_child_id){
            $query->whereIn("id",$array_child_id);
        })->Wherehas("Color",function($query) use($from,$to,$color,$size){
            if($from > 0 || $to > 0) $query->whereBetween("price",[$from,$to]);
            if($color->count() > 0) $query->whereIn("colors_id",$color);
            if($size->count() > 0) $query->whereIn("sizes_id",$size);
        })->where('Post_Status',1)->skip($request->input("start"))->take($request->input("limit"))->get();
       
        $dem2=0;
          $data = array();           
                    foreach($post as $vpost)
                    {
                         array_push($data,$vpost->toArray()); 
                       $id_color = product_color_size::select('colors_id','Album')->where('posts_id',(int)$vpost->id)->groupBy('colors_id')->get();                       
                       $dem3 = 0;
                       //dd($id_color);
                       foreach($id_color as $v2)
                       { 
                       
                            $a = array();                           
                           $data[$dem2]["Color"][$dem3]= Color::find($v2->colors_id)->toArray()  ;
                            $data[$dem2]["Color"][$dem3]["album"]= $v2->Album;   
                             $id_size = product_color_size::select(DB::raw("group_concat(Distinct sizes_id SEPARATOR ',') as ID"))->where('posts_id',(int)$vpost->id)->where('colors_id',$v2->colors_id)->get();
                            $array_id_size = explode(",",$id_size[0]->ID);
                            $demsize = 0;
                            foreach($array_id_size as $idsize)
                            {
                                $data[$dem2]["Color"][$dem3]["Size"][$demsize] = Size::find($idsize)->toArray();
                                $demsize++; 
                            }
                                            
                            $dem3++;                                                                        
                       }


                       $dem2++;
                    }
            
        
            $jsondata["data"]  =  $data;        // dd($data);
         return Response()->json([$jsondata]);
        
    }
    public function getsubcate(Terms $terms)
    {
         $config = Config::all()->toArray();         
         $data = array();
         array_push($data,$terms->toArray());
         foreach($terms->childs as $v)
         {
              array_push($data,$v->toArray());
         }       
         return Response()->json($data);
    }
  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Posts $product)
    {
        //
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
