<nav id="menu">

	<ul>

		@foreach ($menucha as $v)

			<li class="{{$v->id}}">

           		{{-- <img src="{{($v->Image=="")? '/uploads/avatar/30-17-cat_b706c0f50035bddb63ca6e91efef7703.png' : $v->Image}}">  --}}

           		<a href="{{App\Helpers\Helper::get_link_menu($v)}}">{{$v->name}}</a>

           		@php 

           			if(isset($v->children))

           			{           				

           		@endphp

           		<ul class="menuthuong">

           			@foreach ($v->children as $v1)

           				<li class="341">

           				

           					<a href="{{App\Helpers\Helper::get_link_menu($v1)}}">{{$v1->name}}</a> 

           						@php 

				           			if(isset($v1->children))

				           			{           				

				           		@endphp

	           					 <ul class="menuchau">

	           					 		@foreach ($v1->children as $v2)

	           					 	<li class="368">

	           					 		

	           					 			<a href="{{App\Helpers\Helper::get_link_menu($v2)}}">{{$v2->name}}</a> 

	           					 		</li>

	           					 		@endforeach

	           					 </ul>

	           					 @php  } @endphp

           				</li>

           			@endforeach

           			

           		</ul>

           		@php  } @endphp

           	</li> 

		@endforeach  
          
             
          
	</ul>



</nav>