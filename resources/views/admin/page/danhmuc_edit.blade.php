@extends('admin.index')



@section('content')

	

	<form action="danhmuc/edit/{{$cate->id}}" method="post">
			<input type="hidden" name="lang" value="{{$cate->lang}}">
			<div class="boxwhite">

				<div class="row">

					<div class="col-md-8">

                    	<div class="form-group" style="display: none;">

							

							<select id="language" name="language" class="form-control" >								

								<option value="1">es</option>						</select>

						</div>

						<div class="form-group" >

							<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Categories Parent </label>

							<select id="idParent" name="idParent" class="form-control">

								<option value="0">Không</option>	

								{!!  App\Helpers\Helper::menu_combobox($allMenus,0,"",array($cate->Parent)) !!}				

							</select>

						</div>

						<div class="form-group">

							<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Name</label>

							<input type="text" class="form-control" name="TenLoai" placeholder="" value="{{$cate->Name}}">

						</div>

						<div class="form-group">

							<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Link</label>

							<input type="text" class="form-control" name="slug" value="{{$cate->Slug}}" placeholder="">

						</div>

						<div class="row">

							<!--<div class="col-md-2">

								<div class="form-group">

									<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Thứ tự</label>

									<input type="number" min="0" class="form-control" name="ThuTu" placeholder="" />

								</div>

							</div>-->

							<div class="col-md-3 trangthai">

								<div class="form-group">

									<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Status</label>

									<div class="box-radio">

										<label class="check"><input type="radio" {{ $cate->AnHien == 0 ? "checked" : "" }} name="AnHien" value="0" class="form-radio"> Hide</label>

										<label class="check"><input type="radio" {{ $cate->AnHien == 1 ? "checked" : "" }} name="AnHien"  value="1" class="form-radio"> Show</label>

									</div>

								</div>

							</div>

							<div class="col-md-9 trangthai">

								<div class="form-group">

									<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Type</label>

									<div class="box-radio">

										<label class="check"><input type="radio" {{ $cate->Taxonomy == "tintuc" ? "checked" : "" }}  name="type" value="tintuc" class="form-radio"> News</label>

									

										

										{{-- <label class="check"><input type="radio" {{ $cate->Taxonomy == "sanpham" ? "checked" : "" }} name="type" value="sanpham" class="form-radio"> Product</label> --}}

										<label class="check"><input type="radio" {{ $cate->Taxonomy == "page" ? "checked" : "" }} name="type" value="page" class="form-radio"> Page</label>

										

									</div>

								</div>

							</div>

						</div>



				<div class="form-group mota">

					<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Content</label>

					<textarea class="form-control" id="Content" name="Content" >{{$cate->Content}}</textarea>

				</div>

				

					</div>

					<div class="col-md-4">

						

                        <div class="form-group anhdaidien d-none" >

							<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Avatar</label>

							<div class="box-form">

								<input type="text"  name="Hinh" id="avatar" readonly="" value="{{$cate->Image}}" class="form-control">

								<button type="button" onclick="selectFileWithCKFinder('avatar','imageDD','avatar:/')">choose</button>

								<a title="Xóa ảnh đang chọn" class="del-imageDD"><i class="fa fa-times" aria-hidden="true"></i></a>

							</div>

							<img class="img-anhdaidien" id="imageDD" src="/template/admin/image/noimage.jpg">

						</div>

					</div>

                  

				</div>

			</div>

			

			<div class="boxwhite">

				<!--<div class="form-group">

					<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Title</label>

					<input type="text" class="form-control" name="Title" />

				</div>-->

				<div class="form-group">

					<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Title</label>

					<textarea rows="2" type="text" class="form-control" name="Title">{{$cate->Title}}</textarea>

				</div>

				<div class="form-group">

					<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Keywords</label>

					<textarea rows="2" type="text" class="form-control" name="Keywords">{{$cate->keyword}}</textarea>

				</div>

				<div class="form-group">

					<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Description</label>

					<textarea rows="3" type="text" class="form-control" name="Description">{{$cate->Description}}</textarea>

				</div>

			</div>

			<div class="form-action">

				<button type="submit" name="btn_save"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>

				<a href="danhmuc/list"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>

			</div>

			@csrf

			

		</form>



@endsection

@section('js')

	<script type="text/javascript">

		function selectFileWithCKFinder( elementId, callback ,startupPath ) {

	CKFinder.popup( {

		chooseFiles: true,

		width: 800,

		height: 600,

		selectMultiple:true,

		startupPath: startupPath,

		onInit: function( finder ) {

			finder.on( 'files:choose', function( evt ) {

				var file = evt.data.files.first();

				$("#"+callback).attr("src",file.getUrl());

				$("#"+elementId).val(file.getUrl());

		

	} );

		}

}	);

}

var editor = CKEDITOR.replace('Content' ,{

	uiColor : '#ebf2f6',

	language:'vi',		
	// Cấu hình duyệt file chung (PDF, Word, Zip...)
    filebrowserBrowseUrl: '{{ route('ckfinder_browser') }}?resourceType=Files',
    filebrowserUploadUrl: '{{ route('ckfinder_connector') }}?command=QuickUpload&type=Files',
	filebrowserImageBrowseUrl : '{{ route('ckfinder_browser') }}?resourceType=Images',					  

	filebrowserImageUploadUrl : '{{ route('ckfinder_connector') }}?command=QuickUpload&type=Images',		 

});

var avatar = $("#avatar").val();

if(avatar!="")

{

	$("#imageDD").attr("src",avatar);

}

	</script>

}

@endsection