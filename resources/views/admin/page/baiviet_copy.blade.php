@extends('admin.index')

@section('content')

	<form action="baiviet/add" method="post">
			<div class="boxwhite">
				<div class="row">
					<div class="col-md-8">
                    	
                    	<div class="form-group">
							<label><i class="fa fa-check-circle-o" aria-hidden="true"></i>Tên Tin Tức</label>
							<input type="text" required="required" 	class="form-control" placeholder="Vui lòng nhập tên sản phẩm" value="{{$Post[0]->Post_Title}}" name="Post_Title"  />
						</div>
                    	<div class="form-group">
							<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> link (đường dẫn bài viết)</label>
							<input type="text" class="form-control" value="{{$Post[0]->Post_Name}}" placeholder="ví dụ: ban-thich-choi-game-gi (có thể bỏ trống)" name="Post_Name"  />
						</div> 
                                       												
						<div class="row">	
                        	 <!------------------------------>						
							<div class="col-md-3 trangthai">
								<div class="form-group">
									<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Trạng thái</label>
									<div class="box-radio">
										<label class="check"><input {{($Post[0]->Post_Status==0) ? "checked" : ""}} type="radio" name="Post_Status"  value="0" class="form-radio"/> Ẩn</label>
										<label class="check"><input type="radio" {{($Post[0]->Post_Status==1) ? "checked" : ""}} name="Post_Status" value="1" class="form-radio"/> Hiện</label>
									</div>
								</div>
							</div>
                          
                           
						</div>
						 <div class="row">
                       
                          <!------------------------------>						
							<div class="col-md-3 trangthai"  style="display:none;">
								<div class="form-group">
									<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Số lượng</label>
									<input type="text" class="form-control" value="{{$Post[0]->SoLuong}}" name="SoLuong" />
								</div>
							</div>
                         </div>       
                            <!------------------------------>	  
                             <div class="form-group mota">
                                <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Mô tả ngắn</label>
                                <textarea  class="form-control"  name="Short_Post_Content" rows="5" >{{$Post[0]->Short_Post_Content}}</textarea>
                            </div>   
                      
                              <!------------------------------>	
                               	
                            <div class="form-group mota">
                                <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Chi tiết bài viết</label>
                                <textarea  name="Post_Content" rows="5" >{{$Post[0]->Post_Content}}</textarea>
                            </div>
                             
                            
                            
                            
                       
					</div>
					<div class="col-md-4">
                    	<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Danh mục</label>
						<div class="form-group checkbox ">
                        	{!! \App\Helpers\Helper::menu_checkbox($allMenus,0,'',$cateselect) !!}
                        	
						</div>
                        
                           <!---------avatar-------->
                        <div class="form-group anhdaidien">
						<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Hình đại diện </label>
							<div class="box-form">
								<input type="text" name="Post_Thumb"  id="avatar" readonly="" value="{{$Post[0]->Post_Thumb}}" class="form-control">
								<button type="button" onclick="selectFileWithCKFinder('avatar','imageDD','avatar:/')">Chọn ảnh</button>
								<a title="Xóa ảnh đang chọn" class="del-imageDD"><i class="fa fa-times" aria-hidden="true"></i></a>
							</div>
							<img class="img-anhdaidien" id="imageDD" src="/template/admin/image/noimage.jpg">
                       
						</div>  
  						<!---------album-------->
						
                    
                                       
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
            
				<input type="hidden" name="Post_Type" value="tintuc">
	</div>
    <div class="form-action">
				<button type="submit" name="btn_save"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
				<a href="index.php?page=product"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
			</div>
			@csrf
			
		</form>

@endsection
@section('js')
	<script type="text/javascript">
		var avatar = $("#avatar").val();
if(avatar!="")
{
	$("#imageDD").attr("src",avatar);
}
var url = ($("#Post_Album").val()) ? $("#Post_Album").val() : "";
if(url!="" )
{

	
	url = url.split(",");
	var bien="";
	for(var i=0; i<url.length; i++)
	{
		bien+= "<div class='item_album'><img src='"+url[i]+"' width='100' height='100'><a title='Xóa ảnh' class='del-album' data='"+url[i]+"'><i class='fas fa-times-circle'></i></a></div>";
	}
	$(".album_image-1").prepend(bien);
	$(".del-album").click(function()
	{
			$(this).parent().remove();
			var url = "";
			url = $("#Post_Album").val();
			url = url.split(",");							
			var url_chinh = "";
			var image = $(this).attr("data");
			for(i=0; i<url.length; i++)
			{
				if(image!=url[i])
				{
					url_chinh+=url[i]+",";
				}
			}
			var url_chinh = url_chinh.substring(0, url_chinh.length - 1);
			 $("#Post_Album").val(url_chinh);
	});

}
		function selectFileWithCKFinder( elementId, callback ,startupPath ) {
	CKFinder.popup( {
		chooseFiles: true,
		width: 800,
		height: 600,
		selectMultiple:false,
		startupPath: startupPath,
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
		selectMultiple:true,
		startupPath: startupPath,
		onInit: function( finder ) {
			finder.on( 'files:choose', function( evt ) {
				var bien="";
				var url = "";
				var files = evt.data.files;	
				console.log(files);			   
				    files.forEach( function( file, i ) {
				    	if(url=="")
						{			
							url+= file.get('url');
						}
						else
						{
							url+= ","+file.get('url');
						}				    					   
				        bien+= "<div class='item_album'><img src='"+file.get('url')+"' width='100' height='100'><a title='Xóa ảnh' data_id ='"+file.get('cid')+"' class='del-album' data='"+file.get('url')+"'><i class='fas fa-times-circle'></i></a></div>";
				    } );
				    $(".album_image-1").prepend(bien);	
				   	$("#"+elementId).val(url);
				   	$(".del-album").click(function()
					{
						var id = $(this).attr("data_id");
						$(this).parent().remove();
						var url = "";
						url = $("#"+elementId).val();
						url = url.split(",");							
						var url_chinh = "";
						var image = $(this).attr("data");
						for(i=0; i<url.length; i++)
						{
							if(image!=url[i])
							{
								url_chinh+=url[i]+",";
							}
						}
						var url_chinh = url_chinh.substring(0, url_chinh.length - 1);
						 $("#"+elementId).val(url_chinh);
					});
			} );
			
		}
	} );
}
var Post_Content = CKEDITOR.replace('Post_Content' ,{
	uiColor : '#ebf2f6',
	language:'vi',	
	height: 500,	
	filebrowserImageBrowseUrl : '{{ route('ckfinder_browser') }}?resourceType=Images',			
	filebrowserImageUploadUrl : '{{ route('ckfinder_connector') }}?command=QuickUpload&type=Images',  
});

$(function(){
	
	
	$(".money").keyup(function(e){
        $(this).val(format($(this).val()));
    });
	$(".money").val(format($(".money").val()));
});

	</script>
@endsection