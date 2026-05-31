@extends('admin.index')

@section('content')

	<form action="product/edit_size/{{$Color->id}}" method="post">
			<div class="boxwhite">
				<div class="row">
					<div class="col-md-8">
                    	<div class="form-group">
							<label><i class="fa fa-check-circle-o" aria-hidden="true"></i>Tên </label>
							<input type="text" required="required" value="{{$Color->Name}}" placeholder="Nhập tên " 	class="form-control" name="Name"  />
						</div>
                    	
    <div class="form-action">
				<button type="submit" name="btn_save"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
				<a href="index.php?page=product"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
			</div>
			@csrf
			</div>
		</div>
	</div>

		</form>

@endsection
