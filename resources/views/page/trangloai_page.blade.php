
@extends('index')
@section('content')

<div class="container section_1">
	
	<div class="row">
		@include('blocks.breadcrumb-trangloai')
	</div>
	@php
	    // Xác định đường dẫn đầy đủ đến tệp Blade
	    $view_path = resource_path('views/page/trangloai_page_' . $terms->id . '.blade.php');
	@endphp
	@if (File::exists($view_path))
		@include('page.trangloai_page_' . $terms->id)
	@else
	<div class="row mb-3">
		<div class="col-12  p-0"> 
			<h1 class="text-center title_h1 text-uppercase">{{$terms->Name}}</h1>
			
			{{-- <div class="text-center"> {!!$terms->Content!!}</div> --}}
		   @if ($errors->any())
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
					</ul>
				</div>
			@endif
  	
  		
       
        	
        	<?php 
        		$danhmuc = $terms; $bg = ""; $v = 0;  ?>
        		@include('blocks.layout_page_home')	
           	<?php 
	           //$post = App\Models\Posts::where('Post_Status',1)->orderByDesc('created_at')->limit(10)->get();
	           //  $content = str_replace("{contact}", \App\Helpers\FrontEnd::form_contact(), $terms->Content);
	           // $content = str_replace("{newin}", \App\Helpers\FrontEnd::get_new_product_trangloai($terms,"",$post,''), $content);
	           // echo $content;
        	?>

		</div>		
			
	</div>	
	@endif	
	</div>
	
</div>
	
@endsection
@section('css')
<style type="text/css">

</style>
@endsection
@section('js')
	<script>

</script>
@endsection