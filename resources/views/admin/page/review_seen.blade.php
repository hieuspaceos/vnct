@extends('admin.index')

@section('content')
	<div class="row">
		<div class="col-12">
			 <div class="form-group">
                                <label class="control-label">Name</label>
                                <input name="name" readonly="" class="form-control" type="text" id="title" value="{{$Post->Name}}">
             </div>
             <div class="form-group">
                                <label class="control-label">Email</label>
                                <input name="name" readonly="" class="form-control" type="text" id="title" value="{{$Post->Email}}">
             </div>
             <div class="form-group">
                                <label class="control-label">Order Number</label>
                                <input name="name" readonly="" class="form-control" type="text" id="title" value="{{$Post->Phone}}">
             </div>
             <div class="form-group">
                                <label class="control-label">Subject</label>
                                <input name="name" readonly="" class="form-control" type="text" id="title" value="{{$Post->Address}}">
             </div>
             <div class="form-group">
                                <label class="control-label">Message</label>
                                <textarea readonly class="form-control">{{$Post->Content}}</textarea>
             </div>
             <div class="form-group">
                                <label class="control-label">Time Send</label>
                                 <input name="name" readonly="" class="form-control" type="text" id="title" value="{{$Post->created_at->format('d-m-Y H:i:s')}}">
                               
             </div>
        </div>
      </div>
	
@endsection
@section('js')
	
@endsection