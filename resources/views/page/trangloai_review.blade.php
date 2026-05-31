@extends('index')

@section('content')

<div class="container section_1">



	<div class="row">

		

<nav aria-label="breadcrumb">

  <ol class="breadcrumb">

      <li class="breadcrumb-item"><a href="">Home</a></li>

     

    <li class="breadcrumb-item active" aria-current="page">Review</li>

  </ol>

</nav>

	</div>

	<div class="row mb-3">

		<div class="col-12  p-0"> 

			<h1 class="text-center mb-2 title_h1">CUSTOMER  REVIEW </h1>

			

		<div class="m-0">

      <div class="gallery_tt" id="gallery_review">

                          <div class="grid-sizer"></div>

                           <?php $last_id = 0?>

		@foreach ($posts as $v)

      @include('blocks.review_layout')

      

      <?php $last_id = $v->id; ?>

    @endforeach 

  </div>

    @if ( $last_id>0)

                        <div class="buttonaddreview mb-3" data-id="{{ $last_id }}"  onclick="loadmore_review(this)">Load more</div>

                      @endif

			</div>

		</div>	

		

	</div>

	

</div>

	

@endsection



@section('js')

<script type="text/javascript" src="/template/js/masonry.pkgd.min.js" ></script>

<script type="text/javascript" src="/template/js/loadimage.js" ></script>

	<script type="text/javascript">

    $(function(){
$(window).scroll(function(){
            var cach_top = $(window).scrollTop();
      var divtop =  500;//$(".section_1").offset().top + $(".section_1").height();     
      if(cach_top > divtop){ 
        $('.menupc2').addClass("menu_truotaa"); 
//$(".menumb").addClass("fix-scroll");
      }else{
        $('.menupc2').removeClass("menu_truotaa");
//$(".menumb").removeClass("fix-scroll");
      }
          });
      var grid =$('.gallery_tt').masonry({ 

          itemSelector: '.grid-item',

          columnWidth: '.grid-sizer',   

            percentPosition: true,

          horizontalOrder: false,  

        });

       grid.imagesLoaded().progress( function() { 

                    grid.masonry();

              });

    });

   function loadmore_review(e)

   {

      var id_review = $(e).attr("data-id");

       $.ajax({

          type:"POST",

          url:"/api/loadmore_review",

          data:{id_review:id_review},

          dataType: 'json',

          success: function(msg){ 

            

              if(msg.content!="")

              {

                if(msg.last_id==0)

                {

                    $(e).remove();

                }

                else

                {                 

                  $(e).attr("data-id",msg.last_id);

                }

                $("#gallery_review").append(msg.content);

                var grid  = $( '#gallery_review' ).masonry( 'reloadItems' );

                grid.imagesLoaded().done( function() { 

                  grid.masonry('layout');

                });

              }

              if(msg.last_id==0)

              {

                $(e).remove();

              }

              

              

           }

        });

   }  

  </script>



@endsection