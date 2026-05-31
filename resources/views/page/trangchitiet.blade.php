@extends('index')

@section('content')

<div class="container section_1">

	<div class="row">

	@include('blocks.breadcrumb-trangchitiet')

	</div>

  <h1><?=$title?></h1>
  <div class="post-content mt-3">
    <?=$posts->Post_Content?>
  </div>

@endsection
@push('css')
<style type="text/css">
  .post-content img{max-width: 100%}
  .post-content ul{padding: 0}
</style>
@endpush