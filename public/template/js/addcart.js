function chonmau_trangloai(e,idcolor,idpost,class_product,width,height)

    {

      if(e!="")

      {

         $("."+class_product+" .color div").removeClass("active");

        $(e).addClass("active");

      }

     

      $(".size .data").empty();

        $.get("/laysize/"+idcolor+"/"+idpost,{x:(new Date()).getTime()},function(d)

        {              

            var str = "";         

            var dem_size = 0;

            console.log(d);

            for (let i = 0; i < d.length; i++) {

              dem_size++;

              var active_size = "";

              if(dem_size==1)

              {

                chonsize_trangloai(e,d[i].pivot,width,height);

                active_size = "active";

              }

             

            }            

        });

}

function chonsize_trangloai(e,d,width,height)

    {



        var album =d.album.split(',');

        var price = d.price;

        var sale = d.sale;

        var color = d.colors_id;

        var size = d.sizes_id;

       

        if(sale>0)

        {

         // $(e).parents(".product").find(".gia").text(format_money(price-price*sale/100)+" $");

          // $(e).parents(".product").find(".giagiam").show();

         // $(e).parents(".product").find(".giagiam small").text(format_money(price)+" $"); 



        }

        else

        {

          // $(e).parents(".product").find(".gia").text(format_money(price)+" $");

          //$(e).parents(".product").find(".giagiam").hide();

        }

         //$(e).parents(".product").find(".button_cart").attr("data-sale",sale);

           //$(e).parents(".product").find(".button_cart").attr("data-price",price-price*sale/100);

         //$(e).parent().parent().find(".button_cart").attr("data-color",color);

         // $(e).parents(".product").find(".button_cart").attr("data-size",size);

         // $(e).parents(".product").find(".button_cart").attr("data-image",album[0]);                  

           var dem_img = 0;

                         

                $(e).parent().parent().find(".hinhlon").attr("src","/uploads/resize/"+width+"x"+height+"/"+basename(album[0]));

                $(e).parent().parent().find(".hinhlon").attr("data-original-img-retina","/uploads/resize/"+width+"x"+height+"/"+basename(album[0]));

                $(e).parent().parent().find(".hinhlon").attr("data-alternative-img","/uploads/resize/"+width+"x"+height+"/"+basename(album[1]));

            

       

    }

function basename(path) {

   return path.split('/').reverse()[0];

} 



function chonmau(e,idcolor,idpost,width,height)

    {



      if(e!="")

      {

         $(".color div").removeClass("active");

        $(e).addClass("active");

      }

     

      $(".size .data").empty();
//console.log("/laysize/"+idcolor+"/"+idpost);
        $.get("/laysize/"+idcolor+"/"+idpost,{x:(new Date()).getTime()},function(d)

        {              
           
            var str = "";         

            var dem_size = 0;

            for (let i = 0; i < d.length; i++) {

              dem_size++;

              var active_size = "";

              if(dem_size==1)

              {

                chonsize(e,d[i].pivot,width,height);

                active_size = "active";
                 var gia = "";
                if(d[i].pivot.price_sale>0)
                {
                  
                  gia='  <span class="gia"> '+format_money(d[i].pivot.price_sale)+',000 đ </span><br> <span class="giagiam ">   <small> '+format_money(d[i].pivot.price)+',000 đ </small></span>';
                }
                else
                {
                  if(d[i].pivot.price > 0)
                  {
                    gia='  <span class="gia"> '+format_money(d[i].pivot.price)+',000 đ </span>';
                  }
                  else
                  {
                    gia='  <span class="gia"> Liên hệ </span>';
                  }
                }

                $(".gia_sanpham").html(gia);

              }

              if(d[i].id!=1)

              {

              str+= "<div style='background:rgb(242, 242, 242)' class='col-2 text-center  mr-3 "+active_size+"' onclick='chonsize2(this,\""+d[i].pivot.price+"\",\""+d[i].pivot.sale+"\",\""+d[i].pivot.sizes_id+"\")' >"+d[i].Name+"</div>";

            }

            }

            $(".size .data").append(str);

              // $('html,body').animate({

              //     scrollTop: $(".sanpham.product").offset().top - 100

              // }, 0);

        });

        loadreview(idcolor,idpost);

    }

    function chonmau_popup(e,idcolor,idpost,width,height)

    {

      if(e!="")

      {

         $(".product-popup .color div").removeClass("active");

        $(e).addClass("active");

      }

     

      $(".product-popup .size .data").empty();

        $.get("/laysize/"+idcolor+"/"+idpost,{x:(new Date()).getTime()},function(d)

        {              

            var str = "";         

            var dem_size = 0;

            for (let i = 0; i < d.length; i++) {

              dem_size++;

              var active_size = "";

              if(dem_size==1)

              {

                chonsize_popup(e,d[i].pivot,width,height);

                active_size = "active";
                 var gia = "";
                if(d[i].pivot.price_sale>0)
                {
                  
                  gia='  <span class="gia"> '+format_money(d[i].pivot.price_sale)+',000 đ </span><br> <span class="giagiam ">   <small> '+format_money(d[i].pivot.price)+',000 đ </small></span>';
                }
                else
                {
                  if(d[i].pivot.price > 0)
                  {
                    gia='  <span class="gia"> '+format_money(d[i].pivot.price)+',000 đ </span>';
                  }
                  else
                  {
                    gia='  <span class="gia"> Liên hệ </span>';
                  }
                }

                $(".gia_sanpham").html(gia);

              }

              if(d[i].id!=1)

              {

              str+= "<div style='background:rgb(242, 242, 242)' class='col-2 text-center  ml-3 "+active_size+"' onclick='chonsize_popup2(this,\""+d[i].pivot.price+"\",\""+d[i].pivot.sale+"\",\""+d[i].pivot.sizes_id+"\")' >"+d[i].Name+"</div>";

            }

            }

            $(".product-popup .size .data").append(str);

             $('html,body').animate({

                scrollTop: $(".product-popup").offset().top - 100

            }, 0);

        });

    }   

    function chonsize_popup(e,d,width,height)

    {

        var album =d.album.split(',');

        var price = d.price;

        var sale = d.sale;

        var color = d.colors_id;

        var size = d.sizes_id;

       

        

         $(e).parents(".product-popup").find(".button_cart").attr("data-color",color);

          $(e).parents(".product-popup").find(".button_cart").attr("data-size",size);

          $(e).parents(".product-popup").find(".button_cart").attr("data-image",album[0]);

          

           for (var i=0; i<100; i++) {                  

                   $("#quick_product #album_product_big").trigger('remove.owl.carousel', [i])

                             .trigger('refresh.owl.carousel');

            }          

             owl2 = $("#quick_product #album_product_big");

           var dem_img = 0;

           $("#quick_product .owl-thumbs-popup").empty();

            for(i=0; i<album.length; i++)

            {

             if(i==0)

              {

                $("#quick_product .owl-thumbs-popup").append('<button class="owl-thumb-item-popup active"><img src="/uploads/resize/104x156/'+basename(album[i])+'"  ></button>');

                

              }

              else

              {

                $("#quick_product .owl-thumbs-popup").append('<button class="owl-thumb-item-popup"><img src="/uploads/resize/104x156/'+basename(album[i])+'"  ></button>');

              }

              owl2.trigger('add.owl.carousel', '<div class="item " data-thumb="'+album[i]+'"><a style="display:block;"  data-fancybox="gallery" href="'+album[i]+'"><img  src="/uploads/resize/500x500/'+basename(album[i])+'"  ></a></div>').trigger('update.owl.carousel').trigger('refresh.owl.carousel');             

             

          }

       

    }

     function chonsize_popup2(e,price,sale,size){

       $(".size .data div").removeClass("active");

        $(e).addClass("active");

       var price = price;

      var sale = sale;

       if(sale>0)

        {

          //$(e).parents(".product").find(".gia").text(format_money(price-price*sale/100)+" VNĐ");

         //  $(e).parents(".product").find(".giagiam").show();

         // $(e).parents(".product").find(".giagiam small").text(format_money(price)+" VNĐ"); 



        }

        else

        {

           //$(e).parents(".product").find(".gia").text(format_money(price)+" VNĐ");

         // $(e).parents(".product").find(".giagiam").hide();

        }

         //$(e).parents(".product").find(".button_cart").attr("data-sale",sale);

          // $(e).parents(".product").find(".button_cart").attr("data-price",price-price*sale/100);

            $(e).parents(".product-popup").find(".button_cart").attr("data-size",size);

    }

    function chonsize(e,d,width,height)

    {

        var album =d.album.split(',');

        var price = d.price;

        var sale = d.sale;

        var color = d.colors_id;

        var size = d.sizes_id;

       

        if(sale>0)

        {

          /*$(e).parents(".product").find(".gia").text(format_money(price-price*sale/100)+" VNĐ");

           $(e).parents(".product").find(".giagiam").show();

          $(e).parents(".product").find(".giagiam small").text(format_money(price)+" VNĐ"); */



        }

        else

        {

          /* $(e).parents(".product").find(".gia").text(format_money(price)+" VNĐ");

          $(e).parents(".product").find(".giagiam").hide();*/

        }

        // $(e).parents(".product").find(".button_cart").attr("data-sale",sale);

           //$(e).parents(".product").find(".button_cart").attr("data-price",price-price*sale/100);

         $(e).parents(".product").find(".button_cart").attr("data-color",color);

          $(e).parents(".product").find(".button_cart").attr("data-size",size);

          $(e).parents(".product").find(".button_cart").attr("data-image",album[0]);

          

           for (var i=0; i<100; i++) {

                   $("#album_product").trigger('remove.owl.carousel', [i])

                             .trigger('refresh.owl.carousel');

                   $("#album_product_big").trigger('remove.owl.carousel', [i])

                             .trigger('refresh.owl.carousel');

            }

            owl = $("#album_product");

             owl2 = $("#album_product_big");

           var dem_img = 0;

           $(".owl-thumbs").empty();

            for(i=0; i<album.length; i++)

            {

             if(i==0)

              {

                $(".owl-thumbs").append('<button class="owl-thumb-item active"><img src="/uploads/resize/104x156/'+basename(album[i])+'"  ></button>');

                //$(e).parents(".product").find(".hinhlon").attr("src","/uploads/resize/"+width+"x"+height+"/"+basename(album[i]));

                //$(e).parents(".product").find(".hinhlon").attr("src",album[i]);

              }

              else

              {

                $(".owl-thumbs").append('<button class="owl-thumb-item"><img src="/uploads/resize/104x156/'+basename(album[i])+'"  ></button>');

              }

              owl2.trigger('add.owl.carousel', '<div class="item " data-thumb="'+album[i]+'"><a style="display:block;"  data-fancybox="gallery" href="'+album[i]+'"><img  src="/uploads/resize/500x500/'+basename(album[i])+'"  ></a></div>').trigger('update.owl.carousel').trigger('refresh.owl.carousel');

             // owl.trigger('add.owl.carousel', '<div class="item "><img  src="/uploads/resize/104x156/'+basename(album[i])+'"  ></div>').trigger('update.owl.carousel').trigger('refresh.owl.carousel');

             

          }

       

    }

    function chonsize2(e,price,sale,size){

       $(".size .data div").removeClass("active");

        $(e).addClass("active");

       var price = price;

      var sale = sale;

       if(sale>0)

        {

          //$(e).parents(".product").find(".gia").text(format_money(price-price*sale/100)+" VNĐ");

         //  $(e).parents(".product").find(".giagiam").show();

         // $(e).parents(".product").find(".giagiam small").text(format_money(price)+" VNĐ"); 



        }

        else

        {

           //$(e).parents(".product").find(".gia").text(format_money(price)+" VNĐ");

         // $(e).parents(".product").find(".giagiam").hide();

        }

         //$(e).parents(".product").find(".button_cart").attr("data-sale",sale);

          // $(e).parents(".product").find(".button_cart").attr("data-price",price-price*sale/100);

            $(e).parents(".product").find(".button_cart").attr("data-size",size);

    }

function addtocart_popup(e)

{



  var quality = Number(($(".product-popup .qty_priduct").val() > 0)? $(".product-popup .qty_priduct").val(): 1 ); 

  var id = Number($(e).attr("data-id"));  

  var name = $(e).attr("data-name");

  var color = $(e).attr("data-color");

  var size = $(e).attr("data-size");

  var obj = {id:id,quality:quality,color:color,size:size,name:name};  
$(".dathangthanhcong").remove();
   $(".giohang tbody .itemproduct").remove();  

       $(".giohang tbody .itemcoupon").remove();

    $.ajax({

      type:"POST",

      url:"/carts/addcart",

      data:obj,

      dataType: 'json',

      success: function(msg){         



      $(".giohang tbody").prepend(msg.data);

      total_cart(msg);

      $("#quick_product").modal("hide");      

      $("#exampleModalCenter").modal("show"); 

      $(".modal").css({'overflow-y':'auto'});

       

      $(".bacground_push_giohang").css({'display':'flex'});



        }      

    });

}    

function addtocart(e)

{

 

	var quality = Number(($(".qty_priduct").val())? $(".qty_priduct").val(): 1 );

	var id = Number($(e).attr("data-id"));	

  var name = $(e).attr("data-name");

	var color = $(e).attr("data-color");

	var size = $(e).attr("data-size");

	var obj = {id:id,quality:quality,color:color,size:size,name:name};	
$(".dathangthanhcong").remove();

   $(".giohang tbody .itemproduct").remove();  

   $(".giohang tbody .itemcoupon").remove();

	  $.ajax({

	    type:"POST",

	    url:"/carts/addcart",

	    data:obj,

	    dataType: 'json',

	    success: function(msg){      	  

//console.log(msg);

			$(".giohang tbody").prepend(msg.data);

			total_cart(msg);

      $("#quick_product").modal("hide"); 
      $("#exampleModalCenter").find(".alert").remove();
			$("#exampleModalCenter").modal("show");	

			$(".bacground_push_giohang").css({'display':'flex'});

var code = $(".discount_input").val();

         if(code!="")

         {

            discount_input(true);

          }   

		    }		   

	  });

}



function khoitao()

{

  $.ajax({

      type:"POST",

      url:"/carts",    

      dataType: 'json',

      success: function(msg){

       //console.log(msg);

      $(".giohang tbody .itemproduct").remove();   

      $(".giohang tbody").prepend(msg.data);      

      total_cart(msg); 

       // var code = $(".discount_input").val();

       //   if(code!="")

       //   {

       //      discount_input(true);

       //    }      

      }

  });

	

	//str = append_item(JSON.parse(msg.cart));



}				

 

function total_cart(msg)

{

  //console.log(msg);

	if(msg.count > 0)

	{

		$(".chuacosanphamnao").hide();

		$(".thanhtien").text(format_money(msg.total) +",000 đ");

		$(".cohang").show();

	}

	else

	{

		$(".cohang").hide();

		$(".giohang tbody").append("<tr class='chuacosanphamnao'><td colspan='6'> <p>Chưa có sản phẩm nào trong giỏ hàng</p></td></tr>");

	}	

  if(msg.discount>-1)

  {

     $(".discount").text(format_money(msg.discount)+"$");

  } 

	$(".sohang").empty();

	$(".sohang").append(msg.count);

	//$(".tax").text(msg.taxTotal.replace(/\.00$/,''));

	var tong = msg.total;
if(msg.discount>-1)

  {

    tong = tong - format_money(msg.discount); 

  }
  if(tong<75)

  {

    //$(".ship").text("25$");

    //tong = tong + 25;

  }

  else

  {

    //$(".ship").text("FreeShip");

  }

  if(tong > 0)
  {

	$(".tongtien").text(format_money(tong)+",000 đ");		
}
}



function remove_items(element,id,id_opt)

{

	$.ajax({

	    type:"POST",

	    url:"/carts/removebyid",

	    data:{id:id,id_opt:id_opt},

	    dataType: 'json',

	    success: function(msg){

       

	    	total_cart(msg);

        

        if(msg.remove_curent_coupon)

        {         

           $(element).parents('tbody').find('.'+msg.id+'_coupon').find(".coupon__tag").removeClass("active");

        }

        if($(element).parents('tbody').find("."+msg.id).length == 1)

        {

          $(element).parent().parent().next('.itemcoupon').remove();

  	    	$(element).parent().parent().parent().parent().remove();

        }

        else

        {

          $(element).parent().parent().parent().parent().remove();

        }

        var code = $(".discount_input").val();

         if(code!="")

         {

            discount_input(true);

          }  



	    }

	});		

}

function update_coupon(element,id,id_cuopon)

{

  var qty = $(element).parents('.itemproduct').find(".soluong").val(); 



  $.ajax({

      type:"POST",

      url:"/carts/update_coupon",

      data:{id:id,coupon:id_cuopon,qty:qty},

      dataType: 'json',

      success: function(msg){ 

       

        if(msg.error)

        { 

           $(element).parent().find(".coupon__tag").removeClass("active");

          $(element).addClass("active");             

        }

        else

        {

          alert("Chưa đủ điều kiện để sữ dụng");

        }

        

        total_cart(msg);       

      }

  });   

}

function replaceText(selector, text, newText, flags) {

  var matcher = new RegExp(text, flags);

  $(selector).each(function () {

    var $this = $(this);

    if (!$this.children().length)

       $this.text($this.text().replace(matcher, newText));

  });

}

function checkInput(element,id,id_opt)

{

  

	$.ajax({

	    type:"POST",

	    url:"/carts/update_cart",

	    data:{id:id,id_opt:id_opt,qty:$(element).val()},

	    dataType: 'json',

	    success: function(msg){	

      

       // console.log(msg);

	    	total_cart(msg);

        

	    	$(element).parent().parent().parent().find(".total_item_price").text(format_money(Number(msg.item.sub_total))+",000 đ");	    	

        if(msg.remove_curent_coupon)

        {

           $(element).parents('tbody').find('.'+msg.id+'_coupon').find(".coupon__tag").removeClass("active");

        }

        var code = $(".discount_input").val();

         if(code!="")

         {

            discount_input(true);

          }  

	    }

	});	

}

function minus_qty(e,id,id_opt)

  {

     var now = $(e).parent().find(".soluong").val();

                if ($.isNumeric(now)){

                    if (parseInt(now) -1 > 0){ now--;}

                    $(e).parent().find(".soluong").val(now);

                }else{

                    $(e).parent().find(".soluong").val("1");

                }

      checkInput($(e).parent().find(".soluong"),id,id_opt);

  }

  function plus_qty(e,id,id_opt)

  {

     var now = $(e).parent().find(".soluong").val();

                if ($.isNumeric(now)){

                    $(e).parent().find(".soluong").val(parseInt(now)+1);

                }else{

                    $(e).parent().find(".soluong").val("1");

                }

     checkInput($(e).parent().find(".soluong"),id,id_opt);

  }

  function discount_input($auto=false)

  {

   

  }

function format_money(money) {
  
if (money == 0) {
            return 0;
        }
        var tmp = money.toString().split('').reverse().join('');
        var a = [];
        var len = tmp.length;
        var b = true;
        while (b) {
            if (tmp.indexOf(",") > 0) {
                tmp = tmp.replace(",", "");
                b = true;
            }
            else {
                b = false;
            }
        }
        b = true;
        while (b) {
            len = tmp.length;
            if (len % 3 != 0) {
                tmp = tmp.toString() + '0';
                b = true;
            }
            else {
                b = false;
            }
        }
        for (var i = 0; i < tmp.length; i += 3) {
            a.push(tmp[i] + tmp[i + 1] + tmp[i + 2]);
        }
        tmp = a.toString().split('').reverse().join('');
        b = true;
        while (b) {
            if (tmp[0] == 0 || tmp[0] == ',') {
                tmp = tmp.substr(1);
                b = true;
            }
            else {
                b = false;
            }
        }
        return tmp;
    }

//function format_money(money) {

 // return money.toFixed(2);

	/*

if (money == 0) {

            return 0;

        }

        var tmp = money.toString().split('').reverse().join('');

        var a = [];

        var len = tmp.length;

        var b = true;

        while (b) {

            if (tmp.indexOf(",") > 0) {

                tmp = tmp.replace(",", "");

                b = true;

            }

            else {

                b = false;

            }

        }

        b = true;

        while (b) {

            len = tmp.length;

            if (len % 3 != 0) {

                tmp = tmp.toString() + '0';

                b = true;

            }

            else {

                b = false;

            }

        }

        for (var i = 0; i < tmp.length; i += 3) {

            a.push(tmp[i] + tmp[i + 1] + tmp[i + 2]);

        }

        tmp = a.toString().split('').reverse().join('');

        b = true;

        while (b) {

            if (tmp[0] == 0 || tmp[0] == ',') {

                tmp = tmp.substr(1);

                b = true;

            }

            else {

                b = false;

            }

        }

        return tmp;*/

    //}

function loadreview(id_color,id_post)    

{

  $(".color_hidden").val(id_color);

     $.ajax({

          type:"POST",

          url:"/api/loadmore_review",

          data:{id_color:id_color,id:id_post,id_review:1000000000},

          dataType: 'json',

          success: function(msg){

          //console.log(msg); 



            $("#gallery_review").find(".grid-item").remove();

               $("#gallery_review").append(msg.content);



                var grid  = $( '#gallery_review' ).masonry( 'reloadItems' );

                grid.imagesLoaded().done( function() { 

                  grid.masonry('layout');

                });

                reset_start(msg.avg_review,msg.count_review);

                $(".buttonaddreview.loadmore").remove();

              $("#gallery_review").after(' <div class="buttonaddreview loadmore mb-3" data-id="'+msg.last_id+'"  onclick="loadmore_review(this,'+id_color+','+id_post+')">Xem Thêm</div>'); 

          }

    });

}

function reset_start(avg_review,count_review)

{

    var str ='';

     str+='<span style="width: '+avg_review * 20+'%;">Rated <strong class="rating">5</strong> out of 5</span>';

 $(".startting_product").empty();

    $(".startting_product").append(str);

    $(".number_review").remove();

    $(".woocommerce-Reviews-title .count_view").empty();

    $(".woocommerce-Reviews-title .count_view").append(count_review+" ");

    $(".startting_product").after("<span class='number_review'> ("+count_review+") Review </span>");

}