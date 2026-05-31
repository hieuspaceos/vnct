@extends('admin.index')



@section('content')



	<div class="dataTable_wrapper table-responsive">

		

		<table class="table-data dataTables" id="dataTables222">

			<thead>

				<tr>

					<th width="10%">ID Loại</th>

					<th class="text-left">Tên sản phẩm </th>

					<th width="20%" >Hình </th>

                    <th width="15%" >Loại danh mục</th>

                  
					<th width="15%">Thao tác</th>

				</tr>

			</thead>

			<tbody>

				 <?php 

				 $data = array(); 

					foreach ($allPosts as $v) {

						 $data['data'][]= $v;

					}                	

                ?>

                          

                   

			</tbody>

           

		</table>

	</div>

<?php 

 $content = json_encode($data,JSON_UNESCAPED_UNICODE);

$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/public/file/product.txt","wb");

fwrite($fp,$content);

fclose($fp);

?>





@endsection

@section('js')

<script>

$(".delete_category").click(function(e)

{		

	e.preventDefault(e);

	var url = $(this).attr("href");

	var id = $(this).attr("id");

	$.ajax({

			type:"POST",

			url:"ajax.php",

			data:{

				check_category:"",

				id:id

			},

			success: function(msg){

				console.log(msg);

				if(msg.trim() == "khongco")

				{

					window.location.href  = url;

				}

				else

				{

					$(".background,.popup").css({"display":"block"});

					$(".datapopup").empty();

					$(".datapopup").append(msg);

				}

			}

	});	

});

$(document).ready( function () {



    $('#dataTables222').DataTable({

    	"order": [[ 0, "desc" ]],

	 "ajax":  "/public/file/product.txt" ,	

	 "columns" : [

            { "data": "id" },

            { "data": "Post_Title" },         

            { 

            	"render": function ( data, type, full, meta ) {

            	var image = ""; 

            	$check = 0;

            		for(i=0; i<full.color.length; i++)

            		{

            			if(full.color[i].id!=$check)

            			{

	            			var str = full.color[i].pivot.album;
	            			console.log(str);
	            			if(str!=null)
	            			{
	            			str = str.split(','); 
	            			image+='<img src="https://sensenest.vn/'+str[0]+'" width="80" >';
	            			}
	            			image+='';

	            			$check = full.color[i].id;

            			}

            		}

            		   

            		                           		

                     return image;

                 }

             },  

             { 

             	"render": function ( data, type, full, meta ) {  

             		var danhmuc = "";

             		 for(var i=0; i<full.terms.length; i++)

             		 {

             		 	danhmuc+=  full.terms[i].Name+"<br>";

             		 }                  

                     return danhmuc;

                 }

              }, 

             

			{

				sortable: false,

                 "render": function ( data, type, full, meta ) {                    

                     return '<ul class="nav navbar-right panel_toolbox"><li><a href="/admin/product/edit/'+full.id+'"><i class="fa fa-edit"></i></a></li><li><a href="/admin/product/copy/'+full.id+'"><i class="far fa-copy"></i></a></li><li><a onclick="return confirm(\'Bạn có chắc muốn xóa  không\')" href="/admin/product/delete/'+full.id+'"><i class="fa fa-trash"></i></a></li></ul>';

                 }

			}			

        ]

	});	

	//$(".money").text(format($(".money").text()));

} );



</script>

	{{-- expr --}}

@endsection