
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
  		<li class="breadcrumb-item"><a href="">Home</a></li>
  	{{-- @php  
  		$array_bradcrumb = array_reverse($bradcrumb);
  		foreach ($array_bradcrumb as $key => $value) {
  			 echo '<li class="breadcrumb-item"><a href="/'.$value["Slug"].'/">'.$value["Name"].'</a></li>';
  		}
  	@endphp    --}} 
    <li class="breadcrumb-item" aria-current="page"><a href="/{{$terms->Slug}}">{{$terms->Name}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$posts->Post_Title}}</li>
  </ol>
</nav>