@extends('admin.index')



@section('content')



	<div class="dataTable_wrapper table-responsive">

		

		<table class="table-data dataTables" id="dataTables222">

			<thead>

				<tr>					

					<th class="15%">Image</th>

          <th width="20%" >Name</th> 

          <th width="5%" >Start</th>

          <th width="25%" >Comment</th>         

          <th width="10%" >status</th>

          <th width="20%" >Link Product</th>          

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

$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/public/file/menu.txt","wb");

fwrite($fp,$content);

fclose($fp);

?>





@endsection

@section('css')





@endsection

@section('js')



<script>

 

$(document).ready( function () {



 

    var table = $('#dataTables222').DataTable({

    	"order": [[4, "asc" ]],


	 "ajax":  "/public/file/menu.txt" ,	

	 "columns" : [

            { 

               "render": function ( data, type, full, meta ) { 

                  return '<a class="p-0" href="/uploads/review/'+full.Image+'" ><img src="/uploads/review/'+full.Image+'" ></a>';

               }

            },

            { "data": "Name" }, 

             { 

               "render": function ( data, type, full, meta ) { 

                  return full.Start+' <i class="fa fa-star" aria-hidden="true"></i>';

               }

              },

             { "data": "Content" },           

              { 

               "render": function ( data, type, full, meta ) { 

                if(full.status==0)

                {

                  return '<span class="text-white">0</span><input type="checkbox" onchange="changstatus(this,'+full.id+')" class="statuscheckbox" id="switch'+full.id+'" /><label for="switch'+full.id+'" class="statuslabel">Toggle</label><div><a onclick="return confirm(\'Bạn có chắc muốn xóa  không\')" href="/admin/review/delete/'+full.id+'"><i class="fa fa-trash"></i></a></div>';

                }

                if(full.status==1)

                {

                  return '<span class="text-white">1</span><input type="checkbox" onchange="changstatus(this,'+full.id+')" class="statuscheckbox" checked id="switch'+full.id+'" /><label for="switch'+full.id+'" class="statuslabel">Toggle</label>';

                }

              }

            },

           

             {"render": function ( data, type, full, meta ) { 

              return  full.product.Post_Title+"<br><a target='_blank' href='/"+full.product.Post_Name+".html' >Link </a>";

            }



            },

            

          

        ],

  /*  "columnDefs": [ 

            {

                "targets": [ 3 ],

                "visible": false,

                "searchable": false

            },

            {

                "targets": [ 4 ],

                "visible": false,

                "searchable": false

            },

            {

                "targets": [ 6 ],

                "visible": false,

                

            },

            

        ]*/

	});	

    

} );



function changstatus(e,id)

{

 var check = $(e).prop('checked');

 var ok = 0;

 if(check)

 {

  ok = 1;

 }

 $.ajax({

      type:"POST",

      url:"/admin/review/update",

      data:{check:ok,id:id},

      dataType: 'json',

      success: function(msg){ 

        if(msg.success)

        {

          //alert("success");

        } 

      }

    });

}

</script>

	{{-- expr --}}

@endsection