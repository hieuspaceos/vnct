<?php 

 $count_color =  $v_post->Color->reverse()->unique()->count();
 $count_size = $v_post->Size()->count();
 //$array_album = explode(",",$v_post->Post_Thumb);
 $gia = array();
 $giagiam = array();
 if($count_color > 0)
  {
    $dem_color=0;
    foreach ($v_post->Color->unique() as $v)
    {
       $dem_color++;
       if( $dem_color==1)
       {
        $album = explode(",",$v->pivot->album);
         $array_album[0] = $album[0];
         $array_album[1] = "";
         if(isset($album[1]))
         {
          $array_album[1] = $album[1];
          }  
            
       } 
       if( $v->pivot->price_sale > 0)
         {
          array_push($giagiam, $v->pivot->price);
          array_push($gia, $v->pivot->price_sale);          
         }
         else if($v->pivot->price > 0)
         {
           array_push($gia, $v->pivot->price);
           array_push($giagiam, $v->pivot->price_sale);
         }     
  } 

  }
  if($count_color == 0 && $count_size > 0)
  {
    $dem_color=0;
    foreach ($v_post->Size->reverse()->unique() as $v)
    {
       $dem_color++;
       if( $dem_color==1)
       {
        $album = explode(",",$v->pivot->album);
         $array_album[0] = $album[0];
          $array_album[1] = $album[1];
        //$v_post->Sale = $v->pivot->sale;
        //$v_post->Price = $v->pivot->price;
       }
    
   
     } 
  } 
$id_product = rand(10000,99999).$v_post->id.rand(1000000,9999999);

if(count($gia) > 1)
{
  $gia = collect($gia)->sort()->toArray();
  if($gia[0]==0 && $gia[count($gia)-1] ==0)
  {
    $gia = "Liên hệ";
  }
  else
  {    
    $gia = number_format($gia[0], 0, '', ',').",000 đ - ".number_format($gia[count($gia)-1], 0, '', ',').",000 đ <br><del ><small>". number_format($giagiam[0], 0, '', ',').",000 đ - ".number_format($giagiam[count($giagiam)-1], 0, '', ',').",000 đ </small></del>";
  }
}
else
{
   if(empty($gia))
  {
     $gia = "Liên hệ";
  }
  else
  {
    if($giagiam[0] > 0)
    {
      $gia = number_format($gia[0], 0, '', ',').",000 đ <del ><small> ".number_format($giagiam[0], 0, '', ',').",000 đ </small></del>";
    }
    else
    {
      $gia = number_format($gia[0], 0, '', ',').",000 đ";
    }
  }
}
?>
<div class="card-group product product_{{$id_product}}"> 
  
               <div class="card" style="border:none">
                          <Div   style=" " class="khung_tren">
                            <Div class="image" style="overflow:hidden;">
                             <a class=""  href="/{{$v_post->Post_Name}}.html" >
                                {!! \App\Helpers\FrontEnd::image( $array_album[0],$array_album[1],"card-img-top hinhlon","src",271,271,$v_post->Post_Name) !!}
                              {{--  <img class="card-img-top hinhlon" loading="lazy"  style="border:thin solid #f36b22" src="{{ $array_album[0]}}" alt="Card image cap"> --}}
                             </a>
                               <div class="product-actions" data-id="{{$id_product}}">
                                    Xem nhanh <i class="fa fa-eye" aria-hidden="true"></i>
                                </div>
                             </Div>
                             

                            <div class="card-body  p-2" >
                              <h6 class="card-title text-uppercase  "> <a href="/{{$v_post->Post_Name}}.html" > {{$v_post->Post_Title}}</a></h6> 
                              
                    <p class="card-text gia"><?=$gia?></p>
                
                            </div>  
                            </Div>
                           
                            
                          </div>
                          
</div>


