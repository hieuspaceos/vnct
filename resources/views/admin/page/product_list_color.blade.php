@extends('admin.index')



@section('content')



	<div class="dataTable_wrapper">

		

		<table class="table-data dataTables" id="dataTables222">

			<thead>

				<tr>

					<th width="10%">ID Loại</th>

					<th class="text-left">Tên</th>

					

					<th width="15%">Thao tác</th>

				</tr>

			</thead>

			<tbody>

				 <?php 

				 $data = array(); 

					foreach ($list as $v) {

						 $data['data'][]= $v;

					}                	

                ?>

                          

                   

			</tbody>

           

		</table>

	</div>

<?php 

 $content = json_encode($data,JSON_UNESCAPED_UNICODE);

$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/public/file/product_list_color.txt","wb");

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

	 "ajax":  "/file/product_list_color.txt" ,	

	 "columns" : [

            { "data": "id" },

            { "render" : function(data, type, full, meta ){

            	if(full.Name.indexOf(',')>0)

            	{

            		var bg = "linear-gradient(to right, "+full.Name+")";

            	}

            	else

            	{

            		var bg = full.Name;

            	}

            	return '<div style="background:'+bg+'; ">'+full.Name+'</div>';

            } },            

			{

				sortable: false,

                 "render": function ( data, type, full, meta ) {                    

                     return '<ul class="nav navbar-right panel_toolbox"><li><a href="/admin/product/edit_color/'+full.id+'"><i class="fa fa-edit"></i></a></li><li><a onclick="return confirm(\'Bạn có chắc muốn xóa  không\')" href="/admin/product/delete_color/'+full.id+'"><i class="fa fa-trash"></i></a></li></ul>';

                 }

			}			

        ]

	});	

	//$(".money").text(format($(".money").text()));

} );



</script>

	{{-- expr --}}

@endsection