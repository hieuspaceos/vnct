<?php 

namespace App\Helpers;

use Illuminate\Support\Facades\Session;

use App\Models\Terms;

class FrontEnd

{	
	
	public static function image($url,$url2,$class="",$src="src",$width_div="",$height_div="",$alt="",$event="")

	{

		$pos = strpos($url,".gif");		

		$basename = basename($url);	

		$pos2 = strpos($url2,".gif");		

		$basename2 = basename($url2);

		//list($width, $height) = getimagesize($url);

		$array_wh = explode("-",$basename);

		

		$width = $array_wh[0];

		$height = $array_wh[1];			

		$array_size = array(400);

		$str='';

		if($pos===false)

		{



			if(strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false ) {

				if($basename2=="")
				{
					$basename2 = $basename;
				}

				$str.= "<img width='".$width_div."' height='".$height_div."' src='/uploads/resize/".$width_div."x".$height_div."/".$basename."' loading='lazy' ".$event." class='".$class."' title='".$alt."' data-alternative-img='/uploads/resize/".$width_div."x".$height_div."/".$basename2."' data-original-img-retina='/uploads/resize/".$width_div."x".$height_div."/".$basename."'  alt='".$alt."'>";

				

			}

			else

			{
				if($basename2=="")
				{
					$basename2 = $basename;
				}
				$str.= "<img width='".$width_div."' height='".$height_div."' src='/uploads/resize/".$width_div."x".$height_div."/".$basename."' loading='lazy' ".$event." class='".$class."' title='".$alt."' data-alternative-img='/uploads/resize/".$width_div."x".$height_div."/".$basename2."' data-original-img-retina='/uploads/resize/".$width_div."x".$height_div."/".$basename."'  alt='".$alt."'>";

			}

			/*if(strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false ) {				

   				$str.= "<picture>";

   				foreach ($array_size as $value) {

					

   					if($width>$value)

   					{ 					

   					$str.= "<source media='(max-width:".$value."px)' srcset='uploads/resize/".$value."/".$basename.".webp' type='image/webp' >";

   					}

   				}

				if($width_div!="" && $width_div < $width)

				{	

					foreach ($array_size as $value) {

						

							if($width_div <= $value)

							{												

								$str.= "<img width='".$width_div."' height='".$height."' src='uploads/resize/".$value."/".$basename.".webp' loading='lazy' class='".$class."'  alt='Alt Text!'>";

								break;

							}

					}

				}

				else

				{

					$str.= "<img width='".$width."' height='".$height."' src='".$url.".webp' loading='lazy' class='".$class."'  alt='Alt Text!'>";

				}

				$str.="</picture>";

			}

			else

			{

				$str.= "<picture>";

				foreach ($array_size as $value) {

					

   					if($width>$value)

   					{ 					

   					$str.= "<source media='(max-width:".$value."px)' srcset='uploads/resize/".$value."/".$basename."' type='image/jpeg' >";

   					}

   				}								

											

					$str.="  <img src='".$url."' loading='lazy' class='".$class."'  alt='Alt Text!'>

					</picture>";

			}*/					

		}	

		else 

		{
			
			$str= "<img src='".$url."' data-alternative-img='".$url2."' data-original-img-retina='".$url."'  class='".$class."' alt='Alt Text!'>";
			
		}	

		

		return $str;

	}

	public static function form_contact()

	{

		$str = "";

		$str.='<div class="Contact_form">';

		

		$str.='<form action="/api/sendmail" method="post">';

		if(Session::has("success"))

		{

        $str.='<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.Session::get('success').'</div>';

    	}

        elseif(Session::has("failed"))

        {

        $str.='<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.Session::get('failed').'</div>';

        }

		$str.='<div class="form-group">

					

							<input type="text" required value="'.old('name').'" class="form-control" name="name" placeholder="Name *">

				</div>';

		$str.='<div class="form-group">

					

							<input type="text" required value="'.old('email').'" class="form-control" name="email" placeholder="Email *">

				</div>';

		$str.='<div class="form-group">

					

							<input type="text" class="form-control" name="ordernumber" placeholder="Order Number">

				</div>';

		$str.='<div class="form-group">

					

							<input type="text" required value="'.old('subject').'" class="form-control" name="subject" placeholder="Subject *">

				</div>';

		$str.='<div class="form-group mota">					

					<textarea class="form-control" required id="Content" name="Content" placeholder="Your Message...*" >'.old('Content').'</textarea>

				</div>';

		$str.= '<input type="hidden" name="_token" value="'.csrf_token().'">';

		$str.='<button type="submit" class="btn btn-light">Submit</button>';

		$str.='</form>';

		$str.='</div>';

		return $str;

	}

	public static function get_page($id)

	{

		$Terms = Terms::find($id);

		return $Terms->Content;

	}

	public static function get_link($item)
	{
		//

		if($item["link_type"]=="page" && $item["link_value"] != "")
		{
			$term = Terms::find($item["link_value"]);
			return $term->Slug;
		}
		else if($item["link_type"]=="home")
		{
			return url('/');
		}
		else if($item["link_type"]=="news_category")
		{
			$term = Terms::find($item["link_value"]);
			if($term)
			{
				return $term->Slug;
			}
			else
			{
				return null;
			}
		}
	}
}



?>