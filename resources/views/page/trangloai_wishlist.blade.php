@extends('index')
@section('content')
<div class="container">

	<div class="row">
		
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="">Home</a></li>
     
    <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
  </ol>
</nav>
	</div>
	<div class="row mb-3">
		<div class="col-12  p-0"> 
			<h1 class="text-center title_h1">Wishlist </h1>
			
		<div class="row m-0">
		@foreach ($posts as $post)
      <?php $v_post = $post; ?>
      
      <div class="col-6 col-lg-3 mb-4 p-1 position-relative">
        @include("blocks.layout_sanpham")
        <div class="close_wishlist" onclick="remove_wishlist(this,<?=rand(10000,99999);?>{{$v_post->id}}<?=rand(1000000,9999999);?>)"><i class="fa fa-2x fa-times-circle" aria-hidden="true"></i></div>
      </div>
    @endforeach 
			</div>
		</div>	
		
	</div>
	
</div>
	
@endsection
@section('css')
<style type="text/css">


</style>
@endsection
@section('js')
	<script type="text/javascript">
    function remove_wishlist(e,id)
    {
      $(e).parent().remove();
       $.ajax({
          type:"POST",
          url:"/api/wishlist",
          data:{id:id},
          dataType: 'json',
          success: function(msg){               
              $(".wishlist_notification span").remove();
               $(".wishlist_notification").append("<span class='wishlist-quantity'>"+msg.count+"</span>")
              }
        });
    }
  </script>

@endsection