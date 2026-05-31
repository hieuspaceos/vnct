
@extends('index')
@section('content')
<div class="section_1">
	
	<div class="row">
		{{-- @include('blocks.breadcrumb-trangloai') --}}
	</div>
	<?php
			
				echo '<h1 class="title_h1 h3 text-center mb-4 color-blue">Palabras clave de búsqueda: '.$key.'</h1>';
				
				echo '<div class="row">';
				foreach($posts as $v)
				{
					echo '<div class="col-12 col-md-6 col-lg-4 mb-4">';
					echo \App\Helpers\Helper::template_tintuc($v);
					echo '</div>';
				}
				echo '</div>';


				echo '<div class="d-flex justify-content-center mt-5">
				    '.$posts->links().'
				</div>';
		
			
			?>
		
	
</div>
	
@endsection
@section('css')
<style type="text/css">
	
</style>
@endsection
@push('js')
<script>


</script>
@endpush