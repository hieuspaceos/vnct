@extends('admin.index')



@section('content')



	<div class="dataTable_wrapper">

		

		<table class="table-data dataTables" id="dataTables222">

			<thead>

				<tr>					

					<th width="15%" class="text-left">Mã đơn hàng </th>

					<th width="15%" >Tổng giá tiền </th>

                    <th width="15%" >Ngày đặt hàng</th>  
                    <th width="15%" >date</th>  

                    <th width="15%" >Tên khách hàng</th> 

                     <th width="15%" >Số điện thoại</th>

                    <th width="15%" >Trạng thái</th>                 

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

$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/public/file/donhang.txt","wb");

fwrite($fp,$content);

fclose($fp);

?>





@endsection
@section('css')

<link rel="stylesheet" type="text/css" href="/template/admin/css/buttons.dataTables.min.css">

<link rel="stylesheet" type="text/css" href="/template/admin/css/dataTables.dateTime.min.css">



@endsection
@section('js')
<script type="text/javascript" src="/template/admin/js/dataTables.buttons.min.js"></script>

<script type="text/javascript" src="/template/admin/js/jszip.min.js"></script>

<script type="text/javascript" src="/template/admin/js/pdfmake.min.js"></script>

<script type="text/javascript" src="/template/admin/js/vfs_fonts.js"></script>

<script type="text/javascript" src="/template/admin/js/buttons.html5.min.js"></script>

<script type="text/javascript" src="/template/admin/js/buttons.print.min.js"></script>

<script type="text/javascript" src="/template/admin/js/moment.min.js"></script>

<script type="text/javascript" src="/template/admin/js/dataTables.dateTime.min.js"></script>
<script>
 var minDate, maxDate;

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



   var table = $('#dataTables222').DataTable({

    		"order": [[ 0, "desc" ]],
         
	 "ajax":  "/file/donhang.txt" ,	

	 "columns" : [           

            { "data": "CodeOrder" },

             { 

             	 "render": function ( data, type, full, meta ) { 

             	 	return format_money(full.Total)+",000 đ";

             	 }

             },           

             {

             	 "render": function ( data, type, full, meta ) { 

             	 var m = new Date(full.created_at);

					var dateString = m.getUTCDate() +"/"+ (m.getUTCMonth()+1) +"/"+ m.getUTCFullYear()     + " " + m.getUTCHours() + ":" + m.getUTCMinutes() + ":" + m.getUTCSeconds();

					return  dateString;

             	 }             	             

             }, 
             {"data" : "created_at"},
             {

             	"data" : "users.name"

             },

             {

             	"data" : "users.Phone"

             },

              { 

             	 "render": function ( data, type, full, meta ) { 

             	 	if(full.status==0)

             	 	{

             	 		return '<div class="alert alert-danger" role="alert">Mới</div>';

             	 	}

             	 	

             	 	else if(full.status==1)

             	 	{

             	 	 	return '<div class="alert alert-warning" role="alert">Đang vận chuyển</div>';

             	 	}

             	 	else if(full.status==2)

             	 	{

             	 	 	return '<div class="alert alert-success" role="alert">Hoàn tất</di>';

             	 	}

             	 	else if(full.status==3)

             	 	{

             	 	 	return "Hủy";

             	 	}

             	}

             },      

			{

				sortable: false,

                 "render": function ( data, type, full, meta ) {                    

                     return '<ul class="nav navbar-right panel_toolbox"><li><a href="/admin/donhang/edit/'+full.id+'"><i class="fa fa-edit"></i></a></li><li><a onclick="return confirm(\'Bạn có chắc muốn xóa  không\')" href="/admin/donhang/delete/'+full.id+'"><i class="fa fa-trash"></i></a></li></ul>';

                 }

			}			

        ],

    "columnDefs": [ 

            {

                "targets": [ 3 ],

                "visible": false,

               

            },

           
            

        ]

	});	
 $('#min, #max').on('change', function () {

        table.draw();

    });
	//$(".money").text(format($(".money").text()));

} );

function format_money(money) {
    
if (money == 0) {
            return 0;
        }
        var tmp = money.toString().split('').reverse().join('');
        var a = [];
        var len = tmp.length;
        var b = true;
        while (b) {
            if (tmp.indexOf(",") > 0) {
                tmp = tmp.replace(",", "");
                b = true;
            }
            else {
                b = false;
            }
        }
        b = true;
        while (b) {
            len = tmp.length;
            if (len % 3 != 0) {
                tmp = tmp.toString() + '0';
                b = true;
            }
            else {
                b = false;
            }
        }
        for (var i = 0; i < tmp.length; i += 3) {
            a.push(tmp[i] + tmp[i + 1] + tmp[i + 2]);
        }
        tmp = a.toString().split('').reverse().join('');
        b = true;
        while (b) {
            if (tmp[0] == 0 || tmp[0] == ',') {
                tmp = tmp.substr(1);
                b = true;
            }
            else {
                b = false;
            }
        }
        return tmp;
    }

</script>

	{{-- expr --}}

@endsection