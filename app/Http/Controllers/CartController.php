<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use App\Models\Posts;
use App\Models\Coupon;
use Carbon\Carbon;
use App\Models\Size;
use App\Models\Color;
use App\Models\product_color_size;
use Illuminate\Support\Str;
use App\Models\Coupon_detail;
class CartController extends Controller
{
  public function carts()
  {

  	 $data = self::render_product();
         
      
    $array = array(     
      "data" => $data["data"],
      "count" => $data["count"],    
      "total" => $data["total"],
      "discount" => $data["discount"]
    );  			
		return $array;
  }
 
  public function addcart(Request $request)
  {
      $request->id = $request->id;
      $request->id = substr($request->id,5);
      $request->id = substr($request->id,0,-7);
  		$post= Posts::with('Terms')->where("id",(int)$request->id)->get()->first();            
        $title = $post->Post_Title; 
        $brand = $post->brands_id;
        $id  =    (int)$post->id;                 
        $all_terms =  $post->terms()->get(["id"]); 
        $array_items = array();  
        foreach ($all_terms as $key => $v) {
           array_push($array_items,$v->id);
        }
      
       $array_coupon = collect([]);
  		
       $product = product_color_size::where('posts_id',(int)$request->id)
          ->where('sizes_id',(int)$request->size)
          ->where('colors_id',(int)$request->color)->get()->first();
      
       $product_item2 = Posts::find((int)$request->id);
      if(Session::has('shopcart'))
      {

        $session_coupon =  json_decode (json_encode (Session::get('shopcart')), FALSE);
        $check_product = true;
        $check_option = true;

        foreach ($session_coupon as $key1 => $v) 
        {
          foreach ($v->sanpham as $key2 => $sanpham) {
            if($sanpham->id==(int)$request->id)
            {
              $check_product = false;
                //dd($v["sanpham"]["option"]);
               foreach ($sanpham->option as $key3 => $option) {
                    if($option->color==$request->color && $option->size==$request->size)
                    {
                      $check_option = false;
                      $option->soluong = $option->soluong+ $request->quality;
                       $session_coupon[$key1]->sanpham[$key2]->option[$key3]->soluong = $option->soluong;
                       $session_coupon[$key1]->sanpham[$key2]->option[$key3]->sub_total = $option->curent_price * $option->soluong;
                    }
                }                 
                if($check_option)
                {
                  $curent_price = ($product_item2->Price > 0) ? ($product_item2->Price - (($product_item2->Price*$product_item2->Sale)/100)) : (($product->price_sale > 0) ? $product->price_sale : $product->price);
                  $sub_total = $curent_price * (int)$request->quality;
                  array_push( $session_coupon[$key1]->sanpham[$key2]->option,
                   [
                                'rowId' => bcrypt(Str::random(40)),
                               'name' => $request->name, 
                               'color'=> (int)$request->color,
                               'image'=>  $product->Album,
                               'size'=> (int)$request->size,
                               'price' => ($product_item2->Price > 0)? $product_item2->Price : $product->price,
                               'sale' => ($product_item2->Sale > 0)? $product_item2->Sale : $product->price_sale,
                               'soluong' => (int)$request->quality,
                               'curent_price'=>$curent_price,
                               'sub_total'=> $sub_total
                              
                    ]); 
                    $session_coupon[$key1]->count= $session_coupon[$key1]->count + 1;
                  
                }
            }          
          }
        }

        Session::put('shopcart',$session_coupon);
       // return $session_coupon;
        if($check_product)
        {

          $session_coupon = json_decode (json_encode (Session::get('shopcart')), FALSE);
         $curent_price = ($product_item2->Price > 0) ? ($product_item2->Price - (($product_item2->Price*$product_item2->Sale)/100)) : (($product->price_sale > 0) ? $product->price_sale : $product->price);
          $sub_total = $curent_price * (int)$request->quality;
          array_push($session_coupon[0]->sanpham,
          [
                       'rowId' => bcrypt(Str::random(40)),
                       'id' => (int)$request->id,
                       'coupon' => $array_coupon->toArray(),
                       'option' => array([
                                'rowId' => bcrypt(Str::random(40)),
                               'name' => $request->name, 
                               'color'=> (int)$request->color,
                               'image'=>  $product->Album,
                               'size'=> (int)$request->size,
                               'price' => ($product_item2->Price > 0)? $product_item2->Price : $product->price,
                               'sale' => ($product_item2->Sale > 0)? $product_item2->Sale : $product->price_sale,
                               'soluong' => (int)$request->quality,
                               'curent_price'=>$curent_price,
                               'sub_total'=>$sub_total
                             
                              
                       ])
                      
                      ]
                    );
          $session_coupon[0]->count = $session_coupon[0]->count + 1;
           Session::put('shopcart',$session_coupon);
        }
      }
      else
      {
       
       $curent_price = ($product_item2->Price > 0) ? ($product_item2->Price - (($product_item2->Price*$product_item2->Sale)/100)) : (($product->price_sale > 0) ? $product->price_sale : $product->price);
          $sub_total = $curent_price * (int)$request->quality;
        Session::put('shopcart');
        Session::push('shopcart', 
          ['sanpham'=> array([
                       'rowId' => bcrypt(Str::random(40)),
                       'id' => (int)$request->id,
                       'coupon' => $array_coupon->toArray(),
                       'option' => array([
                                'rowId' => bcrypt(Str::random(40)),
                               'name' => $request->name, 
                               'color'=> (int)$request->color,
                               'image'=>  $product->Album,
                               'size'=> (int)$request->size,
                                'price' => ($product_item2->Price > 0)? $product_item2->Price : $product->price,
                               'sale' => ($product_item2->Sale > 0)? $product_item2->Sale : $product->price_sale,
                               'soluong' => (int)$request->quality,
                               'curent_price'=>$curent_price,
                               'sub_total'=>$sub_total
                             
                              
                       ])
                      
                      ]),
          "count" => 1
                    ]);
      } 
      //return "ok";
  		$data = self::render_product();
  		   
  		
		$array = array(			
			"data" => $data["data"],
      "discount" => $data["discount"],
			"count" => $data["count"],		
			"total" => round($data["total"],2)
		);
		return $array;
  }
  public function render_product()
  {
    $data = "";
      $item_cart = json_decode (json_encode (Session::get('shopcart')), FALSE); 
      //dd($item_cart);
       $count_product = 0;
      $count_price = 0;
      $array = array();
      $discount = 0;
      if(!is_null( $item_cart))
      {
       foreach ($item_cart[0]->sanpham as $product) {
         
          $color = "";
          $size = "";
         //dd($product->options);
          foreach ($product->option as $options) {
             $product_item = product_color_size::where('posts_id', $product->id)
          ->where('sizes_id',$options->size)
          ->where('colors_id',$options->color)->get()->first();
            //dd($product_item->toarray());
             $product_item2 = Posts::find($product->id);
              $count_product++;
              if($options->color!="")
              {
                $color = Color::find($options->color);
                $color = $color->Name;
              }
              if($options->size!="")
              {
                $size = Size::find($options->size);
                $size = $size->Name;
              }
          
          $data.='<tr class=" itemproduct">';
          $image = explode(",", $product_item->Album);
        $data.='  <td><img src="'. $image[0].'" width="150" class="py-2" /> </td>';
         
            $data.='<td>';
          $data.='<div class="row py-2">'; 
           $data.='<div class="col-lg-4">'; 
            $data.='  <div>'.$options->name.'</div>';
             if($color!="")
            {
              $data.='<div>Loại: '.$color.'</div>';
            }
            if($size!="" && $size!="không")
            {
              $data.='<div>Size: '.$size.'</div>';
            }
            $data.='</div>';
            /*====== số lượng ======= */
          $data.='<div class="col-lg-2">'; 
          $data.=' <div class="d-flex justify-content-start justify-content-lg-center j">
                                        <div class="btn-minus" onclick="minus_qty(this,\''.$product->rowId.'\',\''.$options->rowId.'\')"><i class="fa fa-minus" aria-hidden="true"></i>
</div>
                                        <input value='.$options->soluong.' onchange="checkInput(this,\''.$product->rowId.'\',\''.$options->rowId.'\')" class="soluong qty_priduct" />
                                        <div class="btn-plus" onclick="plus_qty(this,\''.$product->rowId.'\',\''.$options->rowId.'\')"><i class="fa fa-plus" aria-hidden="true"></i>
</div>
                                    </div>';
          $data.='</div>'; 
          /*====== Giá tièn6 ======= */
          $data.='<div class="col-6 col-lg-3">'; 

          if($product_item2->Sale>0)
          {
            $data.='<div class="price" ><small style="text-decoration: line-through;
    color: #c9c9c9;">'.$product_item2->Price.' $</small><br>';
            $data.='-'.$product_item2->Sale.'%<br>';
          
            if($product_item2->Sale>0)
            {
              $tiengoc =  $product_item2->Price - (($product_item2->Price*$product_item2->Sale)/100);
            }
            $data.=$tiengoc.' $<br>';
            $data.='</div>';
          }
          else
          {
            if($product_item2->Price > 0)
            {
              $tiengoc = $product_item2->Price;
               $data.='<div class="price" >'.$tiengoc.' $</div>';
            }
            else
            {
              if($product_item->price_sale>0)
              {
                $tiengoc =$product_item->price_sale;
                   $data.='<div class="price" ><small style="text-decoration: line-through;
    color: #c9c9c9;">'.number_format($product_item->price, 0, '', ',').',000 đ</small><br>';
                   $data.=number_format($product_item->price_sale, 0, '', ',').',000 đ<br>';
                    $data.='</div>';
              }
              else
              {
                $tiengoc =$product_item->price;
                 $data.='<div class="price" >'.number_format($product_item->price, 0, '', ',').',000 đ</div>';
              }
            }
          }
          
           $data.='</div>';
          /*======Thành tiền ======= */
          $data.='<div class="col-6 col-lg-2">';
          $data.='<div class="total_item_price">'.number_format($tiengoc*$options->soluong, 0, '', ',').',000 đ</div>';
          $data.='</div>';
           /*====== end Thành tiền ======= */  
           /*======remove ======= */
          $data.='<div class="col-lg-1">';
          $data.='<button onclick="remove_items(this,\''.$product->rowId.'\',\''.$options->rowId.'\')" class="btn btn-sm btn-danger xoasanpham"><i class="fa fa-trash"></i> </button>';
          $data.='</div>';
           /*====== end remove ======= */         
          $data.='</div>';  
          
        $data.='</td>';
         

         
        
        
          $data.='</tr>';
          $count_price = $count_price + ($tiengoc*$options->soluong);
          
       
        } 

       $discount = $discount + self::discount($product,1);

        } 
        $discount = $discount + self::discount();
        
         return $array = array(      
                  "data" => $data,
                  "count" => $item_cart[0]->count,    
                  "total" => $count_price,
                  "discount"=>  $discount
                );
      }
        return $array = array(  
                "data" => array(),
                  "count" => 0,    
                  "total" => 0,
                  "discount"=>  0
        );
  }
  public function update_cart(Request $request)
  {



  	 $session_coupon =  json_decode (json_encode (Session::get('shopcart')), FALSE);
     $item = 
       $count_price = 0;
        foreach ($session_coupon as $key1 => $v) {
          foreach ($v->sanpham as $key2 => $sanpham) {
            if($sanpham->rowId==$request->id)
            {                           
               foreach ($sanpham->option as $key3 => $option) {
                    if($option->rowId==$request->id_opt)
                    {                     
                      $option->soluong = $request->qty;
                       $session_coupon[$key1]->sanpham[$key2]->option[$key3]->soluong = $option->soluong;
                       $session_coupon[$key1]->sanpham[$key2]->option[$key3]->sub_total = round($option->curent_price * $option->soluong,2);
                       $item = $session_coupon[$key1]->sanpham[$key2]->option[$key3];
                       
                    }
                    $count_price = round($count_price,2) +  round($session_coupon[$key1]->sanpham[$key2]->option[$key3]->sub_total,2);
                } 
                }
                else
                {
                   foreach ($sanpham->option as $key3 => $option) {
                      $count_price = round($count_price,2) + round($option->sub_total,2);
                   }
                }
              }
            }
    Session::put('shopcart',$session_coupon);

    $item_cart = json_decode (json_encode (Session::get('shopcart')), FALSE);     
      $curen_price_product = 0;
      $item_id = 0;
     
      $coupon_id = 0;
      $remove_curent_coupon = false;
      foreach ($item_cart[0]->sanpham as $product) {
        if($product->rowId==$request->id){
           $item_id  = $product->id;
          foreach ($product->option as $options) {
               if($options->sale>0)
                {
                  $tiengoc =  $options->price - (($options->price*$options->sale)/100);
                }
                else
                {
                  $tiengoc = $options->price;
                }
              $curen_price_product = $curen_price_product + ((int)$tiengoc *  $options->soluong);
             
          } 
          if(isset($product->coupon_active))
            {
           $coupon_id =  $product->coupon_active[0]->id;           
            }
       }
      }

      $post= Posts::with('Terms')->where("id",$item_id)->get()->first();            
        $title = $post->Post_Title; 
        $brand = $post->brands_id;
        $id  =    (int)$post->id;                 
        $all_terms =  $post->terms()->get(["id"]); 
        $array_items = array();  
        foreach ($all_terms as $key => $v) {
           array_push($array_items,$v->id);
        }
        $dt = Carbon::now();       
            
        /*$coupon_terms  = Coupon::wherehas("terms",function($query) use ($array_items) {
              $query->whereIn("terms_id",$array_items);  
        })->whereDate('StartDay','<=',$dt)->whereDate('EndDay','>=',$dt)->where("Status",1)->where("id",$coupon_id)->where('NumberOfUse','>',0)->where('MinPriceuse','<=',$curen_price_product)->get();

        $coupon_brands  =Coupon::wherehas("brands",function($query) use ($brand) {
              $query->where("brands_id",$brand);  
        })->whereDate('StartDay','<=',$dt)->whereDate('EndDay','>=',$dt)->where("Status",1)->where("id",$coupon_id)->where('NumberOfUse','>',0)->where('MinPriceuse','<=',$curen_price_product)->get();

        $coupon_product  =Coupon::wherehas("posts",function($query) use ($id) {
              $query->where("posts_id",$id);                
        })->whereDate('StartDay','<=',$dt)->whereDate('EndDay','>=',$dt)->where("Status",1)->where('NumberOfUse','>',0)->where("id",$coupon_id)->where('MinPriceuse','<=',$curen_price_product)->get();

        $array_coupon = $coupon_terms
                        ->concat($coupon_brands)
                        ->concat($coupon_product)->unique();*/

           $array_coupon = collect([]);             
      if(count($array_coupon->toArray())==0)
      {
        $remove_curent_coupon = true;
        $item_cart =json_decode (json_encode (Session::get('shopcart')), FALSE);     
          $curen_price_product = 0;
          foreach ($item_cart[0]->sanpham as $key=> $product) {
            if($product->rowId==$request->id){
               unset($item_cart[0]->sanpham[$key]->coupon_active);
            }
          }
          Session::put('shopcart',$item_cart); 
      } 



   
		//$item = Cart::instance('cart')->update($request->id, (int)$request->qty);
		$discount = self::discount($session_coupon);
		$array = array(			
			"count" =>$item_cart[0]->count,			
			"total" => round($count_price,2),
			"item" => $item,
			"discount" => $discount,
      "id"=>$item_id,
      "remove_curent_coupon" => $remove_curent_coupon
		);
		
		return $array;	
  }
  public function discount($item=array(),$home=0)
  {
  	$discount = 0;
  	if($home==1)
  	{
       // dd("ok");               
       if(isset($item->coupon_active))
              {
                $thanhtien = 0;

                foreach ($item->option as $options) {
                   
                     $thanhtien = $thanhtien + ((int) $options->curent_price * (int) $options->soluong);
                }
               
                if($item->coupon_active[0]->Typediscount==0)
                {                
                  $giamgia = ($thanhtien * $item->coupon_active[0]->PricePercent) / 100;
                }
                else
                {
                  $giamgia = $item->coupon_active[0]->PriceNumber;
                }
                 if($item->coupon_active[0]->MaxPricediscount!=0)
                {
                 if($giamgia>  $item->coupon_active[0]->MaxPricediscount)
                  {
                    $discount = $discount + $item->coupon_active[0]->MaxPricediscount;
                  }
                  else
                  {
                    $discount = $discount +$giamgia;
                  }
                  }
                  else
                  {
                    $discount = $discount +$giamgia;
                  }
              }   
              else
              {
                return 0;
              }
          return $discount ;
    }
    else
    {
       $item_cart = json_decode (json_encode (Session::get('shopcart')), FALSE);
      //dd($item_cart);
       $thanhtien = 0;
    	foreach ($item_cart[0]->sanpham as $key => $item) {
          if(isset($item->coupon_active))
          {
                foreach ($item->option as $options) {
                   $thanhtien = $thanhtien + ((int) $options->curent_price * (int) $options->soluong);
                }

                if($item->coupon_active[0]->Typediscount==0)
                {                
                  $giamgia = ($thanhtien * $item->coupon_active[0]->PricePercent) / 100;
                }
                else
                {
                  $giamgia = $item->coupon_active[0]->PriceNumber;
                }
                if($item->coupon_active[0]->MaxPricediscount!=0)
                {
                 if($giamgia>  $item->coupon_active[0]->MaxPricediscount)
                  {
                    $discount =   $discount + $item->coupon_active[0]->MaxPricediscount;
                    $giamgia = $item->coupon_active[0]->MaxPricediscount;
                  }
                  else
                  {
                    $discount = $discount +$giamgia;
                  }
                }
                else 
                {
                  $discount = $discount +$giamgia;
                }  
              $item_cart[0]->sanpham[$key]->discount = round($giamgia,2);
                     
          } 		
    	}
     
      if(isset($item_cart[0]->coupon_active))
      {
        if($item_cart[0]->coupon_active->Typediscount==0)
        { 
          $giamgia = (($item_cart[0]->coupon_active->total_curen_price * $item_cart[0]->coupon_active->PricePercent)/100);
        }
        else
        {
          $giamgia = $item_cart[0]->coupon_active->PriceNumber;
        }
        if($item_cart[0]->coupon_active->MaxPricediscount!=0)
        {
          if($giamgia>  $item_cart[0]->coupon_active->MaxPricediscount)
          {
             $discount = $discount + $item_cart[0]->coupon_active->MaxPricediscount;
          }
          else
          {
                      $discount = $discount +$giamgia;
          } 
        }
        else{ $discount = $discount +$giamgia;}  
        $item_cart[0]->discount =  round($giamgia,2);
      }
        Session::put("shopcart",$item_cart);
    }
      		return $discount ;
    
  }
  public function update_coupon(Request $request)
  {

  		$item_cart = json_decode (json_encode (Session::get('shopcart')), FALSE);     
      $curen_price_product = 0;
      $item_id = 0;
      $cout_price = 0;
      foreach ($item_cart[0]->sanpham as $product) {
        if($product->rowId==$request->id){
           $item_id  = $product->id;
          foreach ($product->option as $options) {
               if($options->sale>0)
                {
                  $tiengoc =  $options->price - (($options->price*$options->sale)/100);
                }
                else
                {
                  $tiengoc = $options->price;
                }
              $curen_price_product = $curen_price_product + ((int)$tiengoc *  $options->soluong);
               $cout_price =  $cout_price + $options->sub_total;
          }              
       }
       else
       {
           foreach ($product->option as $options) {
             $cout_price =  $cout_price + $options->sub_total;
           }
       }
      }

  		$post= Posts::with('Terms')->where("id",$item_id)->get()->first();            
        $title = $post->Post_Title; 
        $brand = $post->brands_id;
        $id  =    (int)$post->id;                 
        $all_terms =  $post->terms()->get(["id"]); 
        $array_items = array();  
        foreach ($all_terms as $key => $v) {
           array_push($array_items,$v->id);
        }
        $dt = Carbon::now();       
            
        $coupon_terms  = Coupon::wherehas("terms",function($query) use ($array_items) {
              $query->whereIn("terms_id",$array_items);  
        })->whereDate('StartDay','<=',$dt)->whereDate('EndDay','>=',$dt)->where("Status",1)->where("id",$request->coupon)->where('NumberOfUse','>',0)->where('MinPriceuse','<=',$curen_price_product)->get();

        $coupon_brands  =Coupon::wherehas("brands",function($query) use ($brand) {
              $query->where("brands_id",$brand);  
        })->whereDate('StartDay','<=',$dt)->whereDate('EndDay','>=',$dt)->where("Status",1)->where("id",$request->coupon)->where('NumberOfUse','>',0)->where('MinPriceuse','<=',$curen_price_product)->get();

        $coupon_product  =Coupon::wherehas("posts",function($query) use ($id) {
              $query->where("posts_id",$id);                
        })->whereDate('StartDay','<=',$dt)->whereDate('EndDay','>=',$dt)->where("Status",1)->where('NumberOfUse','>',0)->where("id",$request->coupon)->where('MinPriceuse','<=',$curen_price_product)->get();

        $array_coupon = $coupon_terms
                        ->concat($coupon_brands)
                        ->concat($coupon_product)->unique();
         // end xu ly coupon   
         //dd(count($array_coupon->toArray())); 

        if(count($array_coupon->toArray())>0)
        {
          $item_cart =json_decode (json_encode (Session::get('shopcart')), FALSE);     
          $curen_price_product = 0;
          foreach ($item_cart[0]->sanpham as $key=> $product) {
            if($product->rowId==$request->id){
               $item_cart[0]->sanpham[$key]->coupon_active = $array_coupon->toArray();
            }
          }
          //dd($item_cart);
          Session::put('shopcart',$item_cart);  		
    			$discount = self::discount();
    			$array = array(			
    				"count" =>$item_cart[0]->count,
    			
    				"total" => round($cout_price,2),
    				"id_old" => $request->id,	    			
    				"error" => true ,
            "discount"  => $discount 				
    			);
		}
		else
		{
      $item_cart = json_decode (json_encode (Session::get('shopcart')), FALSE); 
			$array = array(			
				"count" => $item_cart[0]->count,			
				"total" => round($cout_price,2),
				"id_old" => $request->id,				
				"error" => false
			);
		}
		
		return $array;	
  }

  public function update_coupon_single(Request $request)
  {
   
   
     $total_curen_price = 0;
     $array_item = array();
     $count_price = 0;
    $item_cart = json_decode (json_encode (Session::get('shopcart')), FALSE);
        foreach ($item_cart[0]->sanpham as $key => $product) {
          foreach ($product->option as $key => $options) {
              $total_curen_price = $total_curen_price + $options->sub_total;
          }
        
        }
   $dt = Carbon::now();  
    $coupon = Coupon::where('Code',$request->macoupon)->where('Status',1)->whereDate('StartDay','<=',$dt)->whereDate('EndDay','>=',$dt)->where('NumberOfUse','>',0)->get()->first();   
    if($coupon!=null){
        $coupon->total_curen_price = $total_curen_price;
        $item_cart = json_decode (json_encode (Session::get('shopcart')), FALSE);
        $item_cart[0]->coupon_active = $coupon->toarray();
        Session::put('shopcart',$item_cart);
        $discount_coupon = 0;
         $item_cart = json_decode (json_encode (Session::get('shopcart')), FALSE);
        if($item_cart[0]->coupon_active->Typediscount==0)
        { 
          $giamgia = (($item_cart[0]->coupon_active->total_curen_price * $item_cart[0]->coupon_active->PricePercent)/100);
        }
       
        if($item_cart[0]->coupon_active->MaxPricediscount!=0)
        {
          if($giamgia>  $item_cart[0]->coupon_active->MaxPricediscount)
          {
             $discount_coupon = $discount_coupon + $item_cart[0]->coupon_active->MaxPricediscount;
          }
          else
          {
                      $discount_coupon = $discount_coupon +$giamgia;
          } 
        }
        else
        {
           $discount_coupon = $discount_coupon +$giamgia;
        }
        $item_cart = json_decode (json_encode (Session::get('shopcart')), FALSE);
        foreach ($item_cart[0]->sanpham as $key => $product) {
          foreach ($product->option as $key => $options) {
              $count_price = $count_price + $options->sub_total;
          }
        
        }


        $discount = self::discount();
         $array = array(  
            "total" => round($count_price,2), 
            "count" => $item_cart[0]->count,  
            "discount" =>round($discount,2),
            "discount_coupon" =>round($discount_coupon,2),      
           );
    }
    else
    {
      $item_cart = json_decode (json_encode (Session::get('shopcart')), FALSE);
        foreach ($item_cart[0]->sanpham as $key => $product) {
          foreach ($product->option as $key => $options) {
              $count_price = $count_price + $options->sub_total;
          }
        
        }
        if(isset($item_cart[0]->coupon_active))
        {
            unset($item_cart[0]->coupon_active);
            unset($item_cart[0]->discount);
        }
        Session::put('shopcart',$item_cart);
        $discount = self::discount();
        $array = array(  
            "total" => round($count_price,2), 
            "count" => $item_cart[0]->count,  
            "discount" =>$discount,   
            "thongbao" =>"Chưa đủ điều kiện sữ dụng hoặc Mả coupon không đúng",
              
        );
    }
     
  
    
    return $array;  
  }
  public function removebyid(Request $request){		
		$item_cart = json_decode (json_encode (Session::get('shopcart')), FALSE);     
     $cout_price = 0;
       $id = 0;
       $check_option_after_remove = true;
      foreach ($item_cart[0]->sanpham as $key_p =>  $product) {
        if($product->rowId==$request->id)
        {
          $id = $product->id;        
          foreach ($product->option as $key_opt => $options) 
          {
            if($options->rowId==$request->id_opt){
                 if(count($product->option)==1)
                  {
                      array_splice($item_cart[0]->sanpham,$key_p, 1);
                      $check_option_after_remove = false;
                  }
                  else
                  {
                  array_splice($item_cart[0]->sanpham[$key_p]->option,$key_opt,1);
                  }
               $item_cart[0]->count = $item_cart[0]->count -1 ;   
            }
            else 
            {                
                 $cout_price =  $cout_price + $options->sub_total;              
            }        
          }

        }
        else
        {
          foreach ($product->option as $key_opt => $options) 
          {
             $cout_price =  $cout_price + $options->sub_total;
          }
        }
    }
    //$item_cart = json_decode(json_encode($item_cart), true);
    //dd($item_cart);
     Session::put('shopcart',$item_cart);

      $remove_curent_coupon = false;
     if($check_option_after_remove)
     {
		 $item_cart = json_decode (json_encode (Session::get('shopcart')), FALSE);     
      $curen_price_product = 0;
      $item_id = 0;
     
      $coupon_id = 0;
     
      foreach ($item_cart[0]->sanpham as $product) {
        if($product->rowId==$request->id){
           $item_id  = $product->id;
          foreach ($product->option as $options) {
               if($options->sale>0)
                {
                  $tiengoc =  $options->price - (($options->price*$options->sale)/100);
                }
                else
                {
                  $tiengoc = $options->price;
                }
              $curen_price_product = $curen_price_product + ((int)$tiengoc *  $options->soluong);
             
          } 
          if(isset($product->coupon_active))
            {
           $coupon_id =  $product->coupon_active[0]->id;           
            }
       }
      }

      $post= Posts::with('Terms')->where("id",$item_id)->get()->first();            
        $title = $post->Post_Title; 
        $brand = $post->brands_id;
        $id  =    (int)$post->id;                 
        $all_terms =  $post->terms()->get(["id"]); 
        $array_items = array();  
        foreach ($all_terms as $key => $v) {
           array_push($array_items,$v->id);
        }
        $dt = Carbon::now();       
            
       /* $coupon_terms  = Coupon::wherehas("terms",function($query) use ($array_items) {
              $query->whereIn("terms_id",$array_items);  
        })->whereDate('StartDay','<=',$dt)->whereDate('EndDay','>=',$dt)->where("Status",1)->where("id",$coupon_id)->where('NumberOfUse','>',0)->where('MinPriceuse','<=',$curen_price_product)->get();

        $coupon_brands  =Coupon::wherehas("brands",function($query) use ($brand) {
              $query->where("brands_id",$brand);  
        })->whereDate('StartDay','<=',$dt)->whereDate('EndDay','>=',$dt)->where("Status",1)->where("id",$coupon_id)->where('NumberOfUse','>',0)->where('MinPriceuse','<=',$curen_price_product)->get();

        $coupon_product  =Coupon::wherehas("posts",function($query) use ($id) {
              $query->where("posts_id",$id);                
        })->whereDate('StartDay','<=',$dt)->whereDate('EndDay','>=',$dt)->where("Status",1)->where('NumberOfUse','>',0)->where("id",$coupon_id)->where('MinPriceuse','<=',$curen_price_product)->get();*/

      /*  $array_coupon = $coupon_terms
                        ->concat($coupon_brands)
                        ->concat($coupon_product)->unique();*/
         $array_coupon = collect([]);               
      if(count($array_coupon->toArray())==0)
      {
        $remove_curent_coupon = true;
        $item_cart =json_decode (json_encode (Session::get('shopcart')), FALSE);     
          $curen_price_product = 0;
          foreach ($item_cart[0]->sanpham as $key=> $product) {
            if($product->rowId==$request->id){
               unset($item_cart[0]->sanpham[$key]->coupon_active);
            }
          }
          Session::put('shopcart',$item_cart); 
      } }

    $discount = self::discount();
		$array = array(			
			"count" => $item_cart[0]->count,		
			"total" => round($cout_price,2),
			"discount" =>$discount,
      "id" => $id,
      "remove_curent_coupon" => $remove_curent_coupon
		);
		return $array;
	}
   

}
