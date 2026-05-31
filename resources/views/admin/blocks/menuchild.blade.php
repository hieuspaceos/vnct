@foreach($childs as $child)
   <option value="{{$child->id}}">{{$char}} {{$child->Name}}</option>
       <?php 
			$char = $char."--|";
       ?>
   @if(count($child->childs))
            @include('admin.blocks.menuchild',['childs' => $child->childs,'char'=>$char])
        @endif
  
@endforeach