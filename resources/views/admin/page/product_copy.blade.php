@extends('admin.index')



@section('content')



	<form action="product/add" method="post">
<input type="hidden" name="Post_Type" value="sanpham">
			<div class="boxwhite">

				<div class="row">

					<div class="col-md-8">

                    	

                    	<div class="form-group">

							<label><i class="fa fa-check-circle-o" aria-hidden="true"></i>Name</label>

							<input type="text" required="required" 	class="form-control" placeholder="Vui lòng nhập tên sản phẩm" value="{{$Post[0]->Post_Title}}" name="Post_Title"  />

						</div>

                    	<div class="form-group">

							<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> LINK</label>

							<input type="text" class="form-control" value="{{$Post[0]->Post_Name}}" placeholder="ví dụ: ban-thich-choi-game-gi (có thể bỏ trống)" name="Post_Name"  />

						</div> 

                                       												

						<div class="row">	

                        	 <!------------------------------>						

							<div class="col-md-3 trangthai">

								<div class="form-group">

									<label><i class="fa fa-check-circle-o" aria-hidden="true"></i>Status</label>

									<div class="box-radio">

										<label class="check"><input {{($Post[0]->Post_Status==0) ? "checked" : ""}} type="radio" name="Post_Status"  value="0" class="form-radio"/> Ẩn</label>

										<label class="check"><input type="radio" {{($Post[0]->Post_Status==1) ? "checked" : ""}} name="Post_Status" value="1" class="form-radio"/> Hiện</label>

									</div>

								</div>

							</div>

                          

                            <!------------------------------>

                       <div class="col-md-3 ngaydang d-none">

								<div class="form-group">

									<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Listed Price </label>

                                   

                                    <div class="input-group">

									<input type="text" name="Listed_Price"  value="{{$Post[0]->Listed_Price}}"  class="form-control "> 

                                     <div class="input-group-append">

    <span class="input-group-text">$</span>   

  </div>

                                    </div>

								</div>

							</div>

                             <div class="col-md-3 ngaydang d-none">

								<div class="form-group">

									<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Price Buy </label>

                                   

                                    <div class="input-group">

									<input type="text" name="Price"  value="{{$Post[0]->Price}}"  class="form-control "> 

                                     <div class="input-group-append">

    <span class="input-group-text">$</span>   

  </div>

                                    </div>

								</div>

							</div>

                            <div class="col-md-3 d-none">

                                <div class="form-group">

                                <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Sale  </label>             

                                <div class="input-group">

                                <input type="text" value="{{$Post[0]->Sale}}"  name="Sale" class="form-control ">  <div class="input-group-append">    

                                    <span class="input-group-text">%</span>

                                  </div>

                                </div>

                                </div>

                            </div>

                         

						</div>

						 <h3>Attribute</h3>



                            <button type="button" onclick="themattr()" class="btn btn-primary"><i class="fas fa-plus"></i>Add </button>

                            

                            <div class="data-attr">

                            	<?php $dem_attr = 0; ?>

                            	@foreach ($Post[0]->Color->reverse() as $attr)

                            		{{-- expr --}}

                            		<?php $dem_attr++ ?>

                            	<div class="row my-2 item_<?=$dem_attr?>">

                            		@if($dem_attr!=1)

                            		<div class="xoa" onclick="remove(<?=$dem_attr?>)"><i class="far fa-times-circle"></i></div>

                            		@endif

                            		<div class="copy" title="copy" onclick="copy(<?=$dem_attr?>)">

                            			<i class="far fa-copy"></i>

                            		</div>

                            		

                            		<div class="col-4 mt-2 d-none">

                            			<label>Size</label>

                            			<div class="input-group">

                            			<select class="select2 form-control" name="size_attr[]">

                            				<option value="1">Chọn Size</option>

                            				@foreach ($list_size as $v)

                            					<?php

                            						$select = "";

                            						if ($v->id == $attr->pivot->sizes_id) $select = "selected"; ?>

                            					<option {{$select}} value="{{$v->id}}">{{$v->Name}}</option>

                            				@endforeach

                            			</select>

                            			<div class="input-group-append" onclick="themsize()"><span class="input-group-text"><i class="fas fa-plus"></i></span> </div>

                            			</div>

                            		</div>

                            		<div class="col-4 mt-2">

                            			<label>Màu</label>

                            			<div class="input-group">

                            			<select class="select2 form-control" name="color_attr[]">

                            				<option value="1">Chọn Color</option>

                            				@foreach ($list_color as $v)

                            				<?php

                            						$select = "";

                            						if ($v->id == $attr->pivot->colors_id) $select = "selected"; ?>

                            					<option {{$select}} value="{{$v->id}}">{{$v->Name}}</option>

                            				@endforeach

                            			</select>

                            			<div class="input-group-append" onclick="themcolor()"><span class="input-group-text"><i class="fas fa-plus"></i></span> </div>

                            		</div>

                            		</div>

                            		<div class="col-4 mt-2 d-none">

                            			<label>Số lượng</label>

                            			<input type="text" name="soluong_attr[]" required value="{{$attr->pivot->soluong}}" placeholder="Nhập số lượng"  class="form-control">

                            		</div>
                            		<div class="col-4 mt-2">

                            			<label>Giá</label>

                            			<input type="text" name="price_attr[]" required value="{{$attr->pivot->price}}" placeholder="Nhập giá" class="form-control">

                            		</div>
                            		<div class="col-4 mt-2">

                            			<label>Giá giảm</label>

                            			<input type="text" name="price_sale_attr[]" required value="{{$attr->pivot->price_sale}}" placeholder="Nhập giá giảm" class="form-control">

                            		</div>

                            	

                            		<div class="form-group anhdaidien col-12">

                            			<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Album </label>

                            			<div class="box-form">

                            				<input type="text" required name="album_attr[]" readonly value="{{$attr->pivot->album}}" placeholder="bạn chưa chọn ảnh nào..." id="Post_Album<?=$dem_attr?>" class="form-control album">

                            				<button type="button" onclick="selectmultipleFileWithCKFinder('Post_Album<?=$dem_attr?>','album_image-<?=$dem_attr?>','album')">Chọn ảnh</button>	</div>

                            				<div class="album_image-<?=$dem_attr?>">

                            					

                            				</div>

                            			</div> 

                            		</div>

                            		@endforeach

                            </div>

                            

                           

						 <div class="row mt-3">

                       

                          <!------------------------------>						

							

                         </div>       

                            <!------------------------------>	  

                             <div class="form-group mota">

                                <label><i class="fa fa-check-circle-o" aria-hidden="true"></i>Short Content</label>

                                <textarea  class="form-control"  name="Short_Post_Content" rows="5" >{{$Post[0]->Short_Post_Content}}</textarea>

                            </div>   

                      

                              <!------------------------------>	

                               	

                            <div class="form-group mota">

                                <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Content product</label>

                                <textarea  name="Post_Content" rows="5" >{{$Post[0]->Post_Content}}</textarea>

                            </div>

                              <div class="form-group mota d-none">

                                <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Content Sizing</label>

                                <textarea  name="Post_Sizing" rows="5" >{{$Post[0]->Post_Sizing}}</textarea>

                            </div>

                              

                           

                       

					</div>

					<div class="col-md-4">

                    	<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Danh mục</label>

						<div class="form-group checkbox required">

							<div >

								<?php 

									$topcheckbox = "";

									$checkbox_list = "";

									$nocheckbox_list = "";

								?>

								{{-- @foreach ($allMenus as $v)

									<?php 

									if($v->id==$cateselect[0])

									{

										$check = "checked";

									$topcheckbox.= '<div><i class="fas fa-arrows-alt-v"></i> <input '.$check.' type="checkbox" id="'.$v->Slug.'"  name="terms_id[]" value='.$v->id.'> <label for="'.$v->Slug.'"> '.$v->Name.'</label></div>';

									}

									else if(in_array($v->id, $cateselect))

									{

										$check = "checked";

									$checkbox_list.= '<div><i class="fas fa-arrows-alt-v"></i> <input '.$check.' type="checkbox" id="'.$v->Slug.'"  name="terms_id[]" value='.$v->id.'> <label for="'.$v->Slug.'"> '.$v->Name.'</label></div>';

									}

									else

									{

										$nocheckbox_list.= '<div><i class="fas fa-arrows-alt-v"></i> <input  type="checkbox" id="'.$v->Slug.'"  name="terms_id[]" value='.$v->id.'> <label for="'.$v->Slug.'"> '.$v->Name.'</label></div>';

									}

									?>

								@endforeach

								{!!$topcheckbox.$checkbox_list.$nocheckbox_list!!} --}}

                        	 {!! \App\Helpers\Helper::menu_checkbox($allMenus,0,'',$cateselect) !!} 

                        	</div>

						</div>

                        

                           <!---------avatar-------->

                        {{-- <div class="form-group anhdaidien">

						<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Hình đại diện </label>

							<div class="box-form">

								<input type="text" name="Post_Thumb"  id="avatar" readonly="" value="{{$Post[0]->Post_Thumb}}" class="form-control">

								<button type="button" onclick="selectFileWithCKFinder('avatar','imageDD','avatar')">Chọn ảnh</button>

								<a title="Xóa ảnh đang chọn" class="del-imageDD"><i class="fa fa-times" aria-hidden="true"></i></a>

							</div>

							<img class="img-anhdaidien" id="imageDD" src="/template/admin/image/noimage.jpg">

                       

						</div> --}}  

  						<!---------album-------->

						{{-- <div class="form-group anhdaidien">

						<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Album </label>

							<div class="box-form">

								<input type="text" name="Post_Album" value="{{$Post[0]->Post_Album}}" placeholder="bạn chưa chọn ảnh nào..."  id="Post_Album" readonly  class="form-control album" />

								<button type="button" onclick="selectmultipleFileWithCKFinder('Post_Album','album_image','album')">Chọn ảnh</button>						

							</div>

                          <div class="album_image">

                         

                          </div>

						</div>  --}}

                    

                                       

					</div>

				</div>

			</div>

			

			<div class="boxwhite">

            <div class="form-group">

					<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Title</label>

					<input type="text" class="form-control" value="{{$Post[0]->Title}}" name="Title" placeholder="title để Seo"/>

				</div>

				<div class="form-group">

					<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Keywords</label>

					<textarea rows="2" type="text" class="form-control" placeholder="keywords meta để Seo" name="Keyword" >{{$Post[0]->Keyword}}</textarea>

				</div>

				<div class="form-group">

					<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Description</label>

					<textarea rows="3" type="text" class="form-control" placeholder="Description meta để Seo" name="Desription" >{{$Post[0]->Desription}}</textarea>

				</div>

			</div>

            </div>

            

			

	</div>

    <div class="form-action">

				<button type="submit" id="save" name="btn_save"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>

				<a href="product/list"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>

			</div>

			@csrf

			

		</form>



@endsection

@section('js')

	<script type="text/javascript">
$(function(){
	$('button#save').click( function() {
		var check = true;
			if($('input[name="terms_id[]"]:checkbox:checked').length < 1)
			{
				alert("Bạn chưa chọn danh mục");
				check = false;
			}
			
			$('.data-attr input[name="album_attr[]"]').each(function(){
				if($(this).val()=="")
				{
					alert("Bạn chưa chọn hình cho sản phẩm");
					check = false;
				}
			});		
			if(check)
			{
				return true;
			}
			else
			{
				return false;
			}
			
	});
});
		var dem_attr = <?=$dem_attr?>;

		function themattr()

		{

			dem_attr++;

			var str = "";

			str+="<div class='row my-2 item_"+dem_attr+"' >";

			if(dem_attr!=1)

			{

			str+='<div class="xoa" onclick="remove('+dem_attr+')"><i class="far fa-times-circle"></i></div>';

			}

			str+='<div class="copy" onclick="copy('+dem_attr+')"><i class="far fa-copy"></i></div>';

			str+='<div class="col-4 mt-2 d-none"><label>Size</label><div class="input-group"><select class="select2 form-control "  name="size_attr[]"><option value="1">Chọn size</option></select><div class="input-group-append" onclick="themsize()"><span class="input-group-text"><i class="fas fa-plus"></i></span> </div></div></div>';

			str+='<div class="col-4 mt-2"><label>Màu</label><div class="input-group"><select class="select2 form-control "  name="color_attr[]"><option value="1">Chọn Màu</option></select><div class="input-group-append" onclick="themcolor()"><span class="input-group-text"><i class="fas fa-plus"></i></span> </div></div></div>';

			str+='<div class="col-4 mt-2 d-none"><label>Số lượng</label><input required type="text" name="soluong_attr[]" value="1000" placeholder=""   class="form-control " /></div>';

			str+='<div class="col-4 mt-2">';

       str+='                     			<label>Giá</label>';

       str+='                     			<input value="0" type="text" required name="price_attr[]" value="" placeholder="Nhập giá" class="form-control">';

       str+='                     		</div>';
       str+='                     		<div class="col-4 mt-2">';

       str+='                     			<label>Giá giảm</label>';

       str+='                     			<input type="text" value="0" required name="price_sale_attr[]" value="" placeholder="Nhập giá giảm" class="form-control">';

       str+='                     		</div>	';

			

			str+='<div class="form-group anhdaidien col-12"><label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Album </label><div class="box-form"><input type="text" required name="album_attr[]" readonly value="" placeholder="bạn chưa chọn ảnh nào..."  id="Post_Album'+dem_attr+'"   class="form-control " /><button type="button" onclick="selectmultipleFileWithCKFinder(\'Post_Album'+dem_attr+'\',\'album_image-'+dem_attr+'\',\'album\')">Chọn ảnh</button>	</div><div class="album_image-'+dem_attr+'"><div class="clear"></div></div></div> ';

			str+='</div>';

			$(".data-attr").append(str);

			$.get("/admin/product/get_list_color",{x:(new Date()).getTime()},function(d)

			{ 				

				$(".data-attr .item_"+dem_attr+" select[name='color_attr[]']").html(d);

			});

			$.get("/admin/product/get_list_size",{x:(new Date()).getTime()},function(d)

			{ 				

				$(".data-attr .item_"+dem_attr+" select[name='size_attr[]']").html(d);

			});

			

			$(".data-attr").animate({ scrollTop: $(".data-attr").prop("scrollHeight")}, 1000);

			 $('.select2').select2();

		}

		var avatar = $("#avatar").val();

if(avatar!="")

{

	$("#imageDD").attr("src",avatar);

}

$(".album").each(function(){

	var url = ($(this).val()!="") ? $(this).val() : "";

	if(url!="" )

	{	

		url = url.split(",");

		var bien="";

		for(var i=0; i<url.length; i++)

		{

			 bien+= '<div class="item_album"><img src="https://sensenest.vn/'+url[i]+'" width="100" height="100"><a title="Xóa ảnh" onclick="return remove_item_album(this,\''+$(this).attr("id")+'\')" data_id ="'+url[i]+'" class="del-album" data="'+url[i]+'"><i class="fas fa-times-circle"></i></a></div>';

			

		}

		$(this).parent().next().prepend(bien);

		

	}

});



		function selectFileWithCKFinder( elementId, callback ,startupPath ) {

	CKFinder.popup( {

		chooseFiles: true,

		width: 800,

		height: 600,

		selectMultiple:false,

		resourceType: startupPath,

		onInit: function( finder ) {

			finder.on( 'files:choose', function( evt ) {

				var file = evt.data.files.first();

				$("#"+callback).attr("src",file.getUrl().replace("<?=env('APP_URL')?>",""));

				$("#"+elementId).val(file.getUrl().replace("<?=env('APP_URL')?>",""));

		

	} );

		}

}	);

}

function selectmultipleFileWithCKFinder( elementId, callback ,startupPath ) {

	CKFinder.popup( {

		chooseFiles: true,

		width: 800,

		height: 600,		

		resourceType: startupPath,

		onInit: function( finder ) {

			finder.on( 'files:choose', function( evt ) {

				var bien="";

				var url = $("#"+elementId).val();

				var files = evt.data.files;							  

				    files.forEach( function( file, i ) {

				    	if(url=="")

						{			

							url+= file.get('url').replace("<?=env('APP_URL')?>","");

						}

						else

						{

							url+= ","+file.get('url').replace("<?=env('APP_URL')?>","");

						}				    					   

				        bien+= '<div class="item_album"><img src="https://sensenest.vn/'+file.get('url').replace("<?=env('APP_URL')?>","")+'" width="100" height="100"><a title="Xóa ảnh" onclick="return remove_item_album(this,\''+elementId+'\')" data_id ="'+file.get('cid')+'" class="del-album" data="'+file.get('url').replace("<?=env('APP_URL')?>","")+'"><i class="fas fa-times-circle"></i></a></div>';

				    } );

				    $("."+callback).append(bien);	

				   	$("#"+elementId).val(url);				   	

			} );

			

		}

	} );

}

var Post_Content = CKEDITOR.replace('Post_Content' ,{

	uiColor : '#ebf2f6',

	language:'vi',		

	filebrowserImageBrowseUrl : '{{ route('ckfinder_browser') }}?resourceType=Images',			  

	filebrowserImageUploadUrl : '{{ route('ckfinder_connector') }}?command=QuickUpload&type=Images',	 

});

var Post_Sizing = CKEDITOR.replace('Post_Sizing' ,{

	uiColor : '#ebf2f6',

	language:'vi',		

	filebrowserImageBrowseUrl : '{{ route('ckfinder_browser') }}?resourceType=Images',			  

	filebrowserImageUploadUrl : '{{ route('ckfinder_connector') }}?command=QuickUpload&type=Images',	 

});

function remove_item_album(e,elementId)

{

	var url = "";



	url = $(e).parents('.anhdaidien').find("input[name='album_attr[]']").val() // 

	//console.log($(e).parents('.anhdaidien').html());

	url = url.split(",");							

	var url_chinh = "";

	var image = $(e).attr("data");

	for(i=0; i<url.length; i++)

	{

		if(image!=url[i])

		{

			url_chinh+=url[i]+",";

		}

	}

	var url_chinh = url_chinh.substring(0, url_chinh.length - 1);

	$(e).parents('.anhdaidien').find("input[name='album_attr[]']").val(url_chinh);

	$(e).parent().remove();		

					

}

function remove(id)

{

	

		if (confirm("Bạn thật sự muốn xóa")) {

    		$(".item_"+id).remove();

			dem_attr--;

  		}

	

}

function copy(id)

{

	dem_attr++;



	var size = $(".item_"+id).find("select[name='size_attr[]']").val();

	var color = $(".item_"+id).find("select[name='color_attr[]']").val();

	var soluong = $(".item_"+id).find("input[name='soluong_attr[]']").val();

	var price = $(".item_"+id).find("input[name='price_attr[]']").val();

	var sale = $(".item_"+id).find("input[name='sale_attr[]']").val();

	var album = $(".item_"+id).find("input[name='album_attr[]']").val();

	var image = $(".item_"+id).find(".album_image-"+id).html();

	var str = "";

			str+="<div class='row my-2 item_"+dem_attr+"' >";

			if(dem_attr!=1)

			{

			str+='<div class="xoa" onclick="remove('+dem_attr+')"><i class="far fa-times-circle"></i></div>';

			}

			str+='<div class="copy" onclick="copy('+dem_attr+')"><i class="far fa-copy"></i></div>';

			str+='<div class="col-4 mt-2 d-none"><label>Size</label><div class="input-group"><select class="select2 form-control "  name="size_attr[]"><option value="1">Chọn size</option></select><div class="input-group-append"><span class="input-group-text"><i class="fas fa-plus"></i></span> </div></div></div>';

			str+='<div class="col-4 mt-2"><label>Size</label><div class="input-group"><select class="select2 form-control "  name="color_attr[]"><option value="1">Chọn Màu</option></select><div class="input-group-append"><span class="input-group-text"><i class="fas fa-plus"></i></span> </div></div></div>';

			

			str+='<div class="col-4 mt-2 d-none"><label>Sớ lượng</label><input type="text required" name="soluong_attr[]" value="1000" placeholder="Nhập số lượng"  class="form-control" /></div>';

				str+='<div class="col-4 mt-2">';

       str+='                     			<label>Giá</label>';

       str+='                     			<input value="0" type="text" required name="price_attr[]" value="" placeholder="Nhập giá" class="form-control">';

       str+='                     		</div>';
       str+='                     		<div class="col-4 mt-2">';

       str+='                     			<label>Giá giảm</label>';

       str+='                     			<input type="text" value="0" required name="price_sale_attr[]" value="" placeholder="Nhập giá giảm" class="form-control">';

       str+='                     		</div>	';


			

			str+='<div class="form-group anhdaidien col-12"><label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Album </label><div class="box-form"><input type="text" required name="album_attr[]" readonly value="" placeholder="bạn chưa chọn ảnh nào..."  id="Post_Album'+dem_attr+'"   class="form-control " /><button type="button" onclick="selectmultipleFileWithCKFinder(\'Post_Album'+dem_attr+'\',\'album_image-'+dem_attr+'\',\'album\')">Chọn ảnh</button>	</div><div class="album_image-'+dem_attr+'"><div class="clear"></div></div></div> ';

			str+='</div>';

			$(".data-attr").append(str);

			$.get("/admin/product/get_list_color",{x:(new Date()).getTime()},function(d)

			{ 				

				$(".data-attr .item_"+dem_attr+" select[name='color_attr[]']").html(d);

				$(".item_"+dem_attr).find("select[name='color_attr[]'] option[value='"+color+"']").attr("selected",true);

			});

			$.get("/admin/product/get_list_size",{x:(new Date()).getTime()},function(d)

			{ 				

				$(".data-attr .item_"+dem_attr+" select[name='size_attr[]']").html(d);

				$(".item_"+dem_attr).find("select[name='size_attr[]'] option[value='"+size+"']").attr("selected",true);

			});

			$(".item_"+dem_attr).find("input[name='soluong_attr[]']").val(soluong);

	$(".item_"+dem_attr).find("input[name='price_attr[]']").val(price);

	$(".item_"+dem_attr).find("input[name='sale_attr[]']").val(sale);

	$(".item_"+dem_attr).find("input[name='album_attr[]']").val(album);	

	$(".item_"+dem_attr).find(".album_image-"+dem_attr).html(image);

	 $(".item_"+dem_attr+" .money_attr").each(function(){

 			$(this).val(format($(this).val()));

    });

			$(".data-attr").animate({ scrollTop: $(".data-attr").prop("scrollHeight")}, 1000);

			 $('.select2').select2();

}

function money(e)

{

	 $(e).val(format($(e).val()));

 

}

$(function(){

	

	$( "#sortable").sortable();

	



	$(".money_attr").keyup(function(e){

        $(this).val(format($(this).val()));

    });

    $(".money_attr").each(function(){

 			$(this).val(format($(this).val()));

    });

     $('.select2').select2();

});



	</script>

@endsection