
<div class="container">
	
<?php 

 $count_color =  $posts->Color->unique()->count();



 $count_size = $posts->Size()->count();

 $array_album = explode(",",$posts->Post_Thumb);

 if($count_color > 0)

  {

     $dem_color=0;

    foreach ($posts->Color->unique() as $v)

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
        // $posts->Sale = $v->pivot->sale;

        // $posts->Price = $v->pivot->price;

       } 

    } 

   

  }

  if($count_color == 0 && $count_size > 0)

  {

     $dem_color=0;

    foreach ($posts->Size->unique() as $v)

    {

       $dem_color++;

       if( $dem_color==1)

       {

        $album = explode(",",$v->pivot->album);

         $posts->Post_Album = $v->pivot->album;

         $array_album[0] = $album[0];

          $array_album[1] = $album[1];

        //posts->Sale = $v->pivot->sale;

        // $posts->Price = $v->pivot->price;

       }



    } 

    

  }

$id_product = rand(10000,99999).$posts->id.rand(1000000,9999999);

?>
	<article class="sanpham product-popup"> 
             		<div class="row">
                    	<div class="col-12 col-md-6 col-lg-6">
                        <div class="row">
                          <div class="d-none d-lg-block col-2 ">
                                    <?php
                                       
                                           //dd($array_album);
                                            //echo '<div class="owl-carousel owl-theme " id="album_product" >';
                                           echo '<div class="owl-thumbs-popup" data-slider-id="1" >';
                                            echo '</div>';
                                       
                                ?>
                                </div>
                        	 <div class="col-md-12 col-lg-10 p-0">
                                <div class="image_one text-center">

                                	 <?php 
                                   echo '<div class="owl-carousel owl-theme " data-slider-id="1" id="album_product_big" >';
                                           
                                            echo '</div>';
                                      // echo '<div class="text-center"> <img class="hinhlon"  src="" /></div>';
                                 ?> 	
                                </div>
                                
                            </div>
                           
                            	
                            
                        </div>
                      </div>
                        <div class="col-12 col-md-6 col-lg-6 col-right ">
                        		<div class="  info  p-3 ">
                            
                                <h1 class="text-uppercase"><?php echo $posts->Post_Title ?></h1>
                                <div class="row mb-2 m-0">
                                	<div class="col-12 p-0">
                                    	
                                        <div class="luotxem">Lượt xem: {{$posts->View}}</div>
                                    </div>
                                	
                           
                                    <div class="gia_sanpham col-8 p-0">
                                       
                                    </div>
                                   
                                </div>
                               
                                   <?php 

                                    $idcolor = 0;

                                    $idpost = 0; 

                                    $divcolor = "";

                                    //echo $count_color;                                     

                                      if($count_color > 0)

                                      {

                                        if($v->id!= 1)

                                            {

                                         //echo '<h6><small> Color </small></h6>';

                                       }

                                         echo ' <div class="row color m-0">';

                                       

                                        $dem_color = 0;

                                       // dd($posts->Color->toarray());

                                          foreach ($posts->Color->unique() as $v)

                                          {

                                            $dem_color++;

                                            $active = "";

                                            if(request()->input('color'))

                                            {

                                               $idcolor = request()->input('color');

                                               $idpost = $id_product;



                                               if($v->id == request()->input('color'))

                                               {

                                                $dema = $dem_color - 1;

                                                $divcolor = '$(".color > div:eq('.$dema.')")';

                                                $active = " active";

                                               }

                                            }

                                            else if($dem_color==1)

                                            {

                                              $active = " active";

                                              $idcolor = $v->id;

                                              $idpost = $id_product;

                                            }

                                            //echo $active;

                                            $album = explode(",",$v->pivot->album);

                                            //dd($v->Name);

                                            if($v->id!= 1)

                                            {

                                               echo '<div  class=" bacdgrond_xam col-md-2 col-3 text-center  mr-3 p-0 '.$active.'" onclick="chonmau_popup(this,'.$v->id.','.$id_product.',540,810)">';

                                              echo $v->Name;

                                             // echo $v->Name;

                                              echo '</div>';



                                          

                                            }

                                            else

                                            {

                                              echo '<div></div>';

                                            }

                                          }

                                          

                                          echo '</div>';

                                       

                                        }

                                    ?>                                                                   
                               
                               
                                
                                <div class="section mt-3" style="padding-bottom:20px;">
                                    <h6 class="title-attr"><small>Qty</small></h6>                    
                                    <div class="d-flex">
                                        <div class="btn-minus"><i class="fa fa-minus" aria-hidden="true"></i>
</div>
                                        <input value="1"  class="soluong qty_priduct" />
                                        <div class="btn-plus"><i class="fa fa-plus" aria-hidden="true"></i>
</div>
                                    </div>
                                </div>
                                <div class="">
                                    {{$posts->Short_Post_Content}}
                                </div>
                                <div onclick="addtocart_popup(this)" class="button_cart background_xanh add-to-cart btn" data-name="{{$posts->Post_Title}}" data-price="<?=($posts->Sale>0) ? $posts->Sale :  $posts->Price?>" data-image="{{$array_album[0]}}" data-color="" data-id="{{$id_product}}"  data-size="<?=(isset($size)) ? $size: "" ?>"   data-sale="<?=($posts->Sale>0) ? $posts->Price :  ''?>">
                            	Thêm vào giỏ hàng
                              </div>
                              <div class="mt-2"><a href="/{{ $posts->Post_Name }}.html">Xem chi tiết </a></div>
                            </div>
                        </div>
                        </div>
                        






                    
    </article>
</div>


<style>
  #quick_product .owl-thumb-item-popup
  {
    border:none;
  }
  #quick_product .owl-thumb-item-popup.active
  {
    border:thin solid;
  }
 #quick_product .owl-nav
 {
  position: absolute;
    top: 50%;
    transform: translate(0%, -50%);
        width: 100%;
 }
 #quick_product .owl-nav button.owl-prev {
    background: #fff !important;
    width: 30px;
    height: 30px;
    float: left;
}
 #quick_product .item a:hover {
    cursor: zoom-in;
}
 #quick_product .owl-nav button.owl-next {
    background:rgba(255,255,255,0.5) !important;
    width: 30px;
    height: 30px;
    float: right;
}
 #quick_product .owl-nav [class*=owl-]:hover
 {
   background:rgba(255,255,255,1) !important;
    color: #000;
 }
 
 #quick_product .owl-theme .owl-nav
 {
  margin-top: 0
 }
 #quick_product  .close:not(:disabled):not(.disabled)
 {
      text-align: right;
    padding-right: 20px;
    padding-top: 9px;
 }
  </Style>



	<script type="text/javascript">
    <?php if($count_color > 0 and $count_size > 0) {  ?>

    chonmau_popup($("#quick_product .color > div:first-child"),<?=$idcolor?>,<?=$id_product?>,540,810);
    <?php } ?>
    $('#quick_product #album_product_big').owlCarousel({
    
      navText : ['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
    loop: false,
  
    items: 1,
    nav: true,
    dots:false,
    thumbs: true,
    thumbImage: true,
     thumbsPrerendered: true,
     thumbContainerClass: 'owl-thumbs-popup',
    thumbItemClass: 'owl-thumb-item-popup'
  });
		
    $(function(){
       $("#quick_product .btn-minus").on("click",function(){
                var now = $(this).parent().find(".soluong").val();
                if ($.isNumeric(now)){
                    if (parseInt(now) -1 > 0){ now--;}
                    $(this).parent().find(".soluong").val(now);
                }else{
                    $(this).parent().find(".soluong").val("1");
                }
            })            
            $("#quick_product .btn-plus").on("click",function(){
                var now = $(this).parent().find(".soluong").val();
                if ($.isNumeric(now)){
                    $(this).parent().find(".soluong").val(parseInt(now)+1);
                }else{
                    $(this).parent().find(".soluong").val("1");
                }
            })             
    })
	</script>
