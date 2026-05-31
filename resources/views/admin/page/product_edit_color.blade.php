@extends('admin.index')

@section('content')

	<form action="product/edit_color/{{$Color->id}}" method="post">
			<div class="boxwhite">
				<div class="row">
					<div class="col-md-8">
                    	<div class="form-group">
							<label><i class="fa fa-check-circle-o" aria-hidden="true"></i>Tên loại</label>
							<input type="text" required="required" value="{{$Color->Name}}" placeholder="Nhập tên loại" 	class="form-control" name="Name"  />
						</div>
                    	<div class="form-group" style="display: none">
							<label><i class="fa fa-check-circle-o" aria-hidden="true"></i>Mã màu</label>
							<input type="color" class="form-control"  value="{{$Color->Ma_Mau}}" name="Ma_Mau"  />
						</div>

    <div class="form-action">
				<button type="submit" name="btn_save"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
				<a href="product/list_color"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
			</div>
			@csrf
			</div>
		</div>
	</div>

		</form>

@endsection
