$(function(){

	$( ".timkiempc" ).autocomplete({

		minLength : 2,

    	delay:500,

      	source: function( request, response ) {

		

        $.ajax( {

			type:"POST",

          url: "/api/search_ajax",

          dataType: "json",

          data: {

            search_complete: request.term

          },

		 

          success: function( data ) {         		  

            response(data.posts);

          }

        } );

      },

      

      select: function( event, ui ) {

		 // console.log(domain+ui.item.post_name+"/");

        window.location = "/"+ui.item.Post_Name+".html?color="+ui.item.color+"";

      }

    })

	.focus(function() {

    				$(this).autocomplete("search", $(this).val());

	})

	.autocomplete( "instance" )._renderItem = function( ul, item ) {

		

				giagiam="";

				if(item.Sale>0)

				{

					giagiam = item.Price - (item.Price * item.Sale / 100);

				}				

				var str="";

				var image = item.image;

				image = image.split(",");

				str+="<div class='row'><div class='col-2'><img style='max-width:100px;max-height:100px;' src='uploads/resize/271x271/"+image[0].split('/').reverse()[0]+"' ></div><div class='col'>"+item.value +"</div></div>";

				// if(giagiam!="")

				// {

				// 	str+="<small class='mr-1'><del>"+parseFloat(item.Price).toFixed(2)+"$</del></small>";

				// }

				

				// if(giagiam=="")

				// 	{

				// 		if(item.Price==0)

				// 		{

				// 			str+="Liên hệ</div></div>";

				// 		}

				// 		else

				// 		{

				// 		str+=parseFloat(item.Price).toFixed(2)+"$</div></div>";

				// 		}

						

				// 	}

				// 	else

				// 	{

				// 	str+= parseFloat(giagiam).toFixed(2)+"$</div></div>";

				// 	}

				

                return $( "<li></li>" )

                    .data( "item.autocomplete", item )

                    .append(str) 

                    .appendTo( ul );

            }

	$( ".timkiemmb" ).autocomplete({

		minLength : 2,

    	delay:500,

      	source: function( request, response ) {

		

        $.ajax( {

			type:"POST",

          url: "/api/search_ajax",

          dataType: "json",

          data: {

            search_complete: request.term

          },

		 

          success: function( data ) {         		  

            response(data.posts);

          }

        } );

      },

      

      select: function( event, ui ) {

		 // console.log(domain+ui.item.post_name+"/");

        window.location = "/"+ui.item.Post_Name+".html?color="+ui.item.color+"";

      }

    })

	.focus(function() {

    				$(this).autocomplete("search", $(this).val());

	})

	.autocomplete( "instance" )._renderItem = function( ul, item ) {

		

				giagiam="";

				if(item.Sale>0)

				{

					giagiam = item.Price - (item.Price * item.Sale / 100);

				}				

				var str="";

				var image = item.image;

				image = image.split(",");

				str+="<div class='row'><div class='col-2'><img style='max-width:100px;max-height:100px;' src='uploads/resize/271x271/"+image[0].split('/').reverse()[0]+"' ></div><div class='col'>"+item.value +"</div></div>";

				// if(giagiam!="")

				// {

				// 	str+="<small class='mr-1'><del>"+parseFloat(item.Price).toFixed(2)+"$</del></small>";

				// }

				

				// if(giagiam=="")

				// 	{

				// 		if(item.Price==0)

				// 		{

				// 			str+="Liên hệ</div></div>";

				// 		}

				// 		else

				// 		{

				// 		str+=parseFloat(item.Price).toFixed(2)+"$</div></div>";

				// 		}

						

				// 	}

				// 	else

				// 	{

				// 	str+= parseFloat(giagiam).toFixed(2)+"$</div></div>";

				// 	}

				

                return $( "<li></li>" )

                    .data( "item.autocomplete", item )

                    .append(str) 

                    .appendTo( ul );

            }
        

$('.timkiempc').keypress(function(event){

	

	

	var keycode = (event.keyCode ? event.keyCode : event.which);

	  if (keycode == '13') {	  	 	

		window.location = "/tim-kiem/"+$(this).val()+"";

	  }

});            

	});

function timtim()

{

	

	window.location = "/tim-kiem/"+$('.timkiempc').val()+"";	   

}

function timtim_mb()

{

	

	window.location = "/tim-kiem/"+$('.timkiemmb').val()+"";	   

}