@extends('admin.index')

@section('content')

	<form action="product/add_color" method="post">
			<div class="boxwhite">
				<div class="row">
					<div class="col-md-8">
                    	<div class="form-group">
							<label><i class="fa fa-check-circle-o" aria-hidden="true"></i>Tên Loại</label>
							<input type="text" required="required" placeholder="Nhập tên loại" 	class="form-control" name="Name"  />
						</div>
                    	<div class="form-group" style="display: none">
							<label><i class="fa fa-check-circle-o" aria-hidden="true"></i>Mã màu</label>
							<input type="color" class="form-control" name="Ma_Mau"  />
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
