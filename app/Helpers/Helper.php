<?php

namespace App\Helpers;

use App\Models\Terms;
use Carbon\Carbon;
class Helper

{
    public static function template_tintuc($post)
    {
        $html = '';
        $html = '<div class="event-post-card">
                            <a href="/'.$post["Post_Name"].'.html"><img src="'.Helper::jcphp01_generate_webp_image($post["Post_Thumb"]).'" class="img-fluid post-thumb" alt="'.$post["Post_Title"].'"></a>
                            <div class="post-content">
                                <h5 class="post-title">
                                    <a href="/'.$post["Post_Name"].'.html">'.$post["Post_Title"].'</a>
                                </h5>
                                <p class="post-source">
                                    <span class="text-muted small">'.Carbon::parse($post["created_at"])->format('d/m/Y').'</span>
                                </p>
                            </div>
                        </div>';
        return $html;
    }
	public static function menu_checkbox($allmenus,$parent_id = 0,$char="",$select_cate=array())

	{

		$html = '';       

		foreach ($allmenus as $k => $v) {

			if($v->Parent==$parent_id)

			{

				$check = "";

				if(in_array($v->id, $select_cate))

				{

					$check = "checked";

				}

				$html.='<div><i class="fas fa-arrows-alt-v"></i> <input '.$check.' type="checkbox" id="'.$v->Slug.'"  name="terms_id[]" value='.$v->id.'> <label for="'.$v->Slug.'"> '.$char.' '.$v->Name.'</label></div>';

				unset($allmenus[$k]);

				$html.=self::menu_checkbox($allmenus,$v->id,$char."--|",$select_cate);

			}

		}

		return $html;

	}
    public static function menu_config($allmenus,$parent_id = 0,$char="",$select_cate=array())

    {

        $html = '';       

        foreach ($allmenus as $k => $v) {

            if($v["Parent"]==$parent_id)

            {

                $check = "";

               

                $html.='<div onclick="themmenu(this)" data-taxonomy="'.$v["Taxonomy"].'" data-id="'.$v["id"].'" data-name="'.$v["Name"].'" data-slug="'.$v["Slug"].'" data-image="'.$v["Image"].'" ><i class="far fa-plus-square"></i>  <label for="'.$v["Slug"].'"> '.$char.' '.$v["Name"].'</label></div>';

                unset($allmenus[$k]);

                $html.=self::menu_config($allmenus,$v["id"],$char."--|",$select_cate);

            }

        }

        return $html;

    }
    public static function menu_combobox($allmenus,$parent_id = 0,$char="",$select_cate=array())

    {

        $html = '';       

        foreach ($allmenus as $k => $v) {

            if($v->Parent==$parent_id)

            {

                $check = "";

                if(in_array($v->id, $select_cate))

                {

                    $check = "selected";

                }

                $html.='<option '.$check.' value='.$v->id.' >'.$char.$v->Name.'</option>';

                unset($allmenus[$k]);

                $html.=self::menu_combobox($allmenus,$v->id,$char."--|",$select_cate);

            }

        }

        return $html;

    }

	public static function user_all_childs_ids($terms)

        {

        	//dd($terms->childs->toArray());

            $all_ids = [];

            if(isset($terms->childs))

            {

                if ($terms->childs->count() > 0) {

                    foreach ($terms->childs as $child) {

                        $all_ids[] = $child->id;

                        $all_ids=array_merge($all_ids,is_array(self::user_all_childs_ids($child))?self::user_all_childs_ids($child):[] );

                    }

                }

            }

            return $all_ids;

    }



    public static function get_all_parent_by_id($terms)

        { 

            $all_terms = [];                    

            if ($terms->parents->count() > 0) {               

                foreach ($terms->parents as $parent) {                

                    $all_terms[] = $parent->toArray();

                    $all_terms=array_merge($all_terms,is_array(self::get_all_parent_by_id($parent))?self::get_all_parent_by_id($parent):[] );                   

                }

            }

            return $all_terms;

    }

    public static function get_link_menu($v)

    {

    	$link = "";

    	if($v->taxonomy=="page")

    	{

    		$link = "/".$v->slug."";

    	}

    	else

    	{

    		$link = "/".$v->slug."";

    	}

    	return $link;

    }

    public static function jcphp01_generate_webp_image($file, $compression_quality = 80)
{
    // An toàn: không làm gì nếu không có file
    if (empty($file) || !is_string($file)) {
        return false;
    }
    
    try {
        // ✅ GIẢI MÃ URL
        $file = urldecode($file);
        
        // ✅ LOẠI BỎ QUERY STRING
        $file = preg_replace('/\?.*$/', '', $file);
        
        // ✅ NẾU ĐÃ LÀ WEBP THÌ TRẢ VỀ LUÔN
        if (strpos($file, '.webp') !== false) {
            return asset(ltrim($file, '/'));
        }
        
        // ✅ GIỮ LẠI URL GỐC
        $original_url = $file;
        
        // ✅ ĐƯỜNG DẪN FILE GỐC
        $source_path = public_path($file);
        
        // ✅ KIỂM TRA FILE GỐC CÓ TỒN TẠI KHÔNG
        if (!file_exists($source_path) || !is_readable($source_path)) {
            return asset(ltrim($original_url, '/'));
        }
        
        // ✅ TẠO FILE WEBP CÙNG THƯ MỤC VỚI FILE GỐC
        $webp_path = $source_path . '.webp';
        
        // ✅ NẾU FILE WEBP ĐÃ TỒN TẠI, TRẢ VỀ URL WEBP
        if (file_exists($webp_path)) {
            return asset(ltrim($original_url . '.webp', '/'));
        }
        
        // ✅ TẠO WEBP MỚI
        $file_type = strtolower(pathinfo($source_path, PATHINFO_EXTENSION));
        
        // Chỉ xử lý jpg và png
        if (!in_array($file_type, ['jpg', 'jpeg', 'png'])) {
            return asset(ltrim($original_url, '/'));
        }
        
        // Thử GD
        if (function_exists('imagewebp')) {
            $image = false;
            
            if (in_array($file_type, ['jpg', 'jpeg'])) {
                $image = @imagecreatefromjpeg($source_path);
            } elseif ($file_type == 'png') {
                $image = @imagecreatefrompng($source_path);
            }
            
            if ($image) {
                if ($file_type == 'png') {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                }
                
                $result = @imagewebp($image, $webp_path, $compression_quality);
                @imagedestroy($image);
                
                if ($result && file_exists($webp_path)) {
                    return asset(ltrim($original_url . '.webp', '/'));
                }
            }
        }
        
        // Thử Imagick
        if (class_exists('Imagick')) {
            try {
                $image = new \Imagick($source_path);
                $image->setImageFormat('webp');
                $image->setImageCompressionQuality($compression_quality);
                $image->writeImage($webp_path);
                $image->destroy();
                
                if (file_exists($webp_path)) {
                    return asset(ltrim($original_url . '.webp', '/'));
                }
            } catch (\Exception $e) {
                // Silent
            }
        }
        
        // ✅ KHÔNG LÀM ĐƯỢC GÌ THÌ TRẢ VỀ ẢNH GỐC
        return asset(ltrim($original_url, '/'));
        
    } catch (\Exception $e) {
        return false;
    } catch (\Throwable $e) {
        return false;
    }
}

private static function getUrlFromPath($path)
{
    try {
        $relative = str_replace(public_path(), '', $path);
        $relative = str_replace('\\', '/', $relative);
        $relative = ltrim($relative, '/');
        
        // ✅ MÃ HÓA LẠI URL CHO ĐÚNG ĐỊNH DẠNG
        $relative = rawurlencode($relative);
        $relative = str_replace('%2F', '/', $relative); // Giữ lại dấu /
        
        return asset($relative);
    } catch (\Exception $e) {
        return false;
    }
}


    public static function resize($newWidth, $originalFile) {

      

    $targetFile = $_SERVER["DOCUMENT_ROOT"] ."/public/uploads/resize/".$newWidth."/";

    

    if (!file_exists($targetFile)) {

                mkdir($targetFile, 0777, true);

    }  

    $originalFile = $_SERVER["DOCUMENT_ROOT"]."/public/".$originalFile;

    $info = getimagesize($originalFile);

    $name = basename($originalFile);

    $mime = $info['mime'];



    switch ($mime) {

            case 'image/jpeg':

                    $image_create_func = 'imagecreatefromjpeg';

                    $image_save_func = 'imagejpeg';

                    $new_image_ext = 'jpg';

                    break;



            case 'image/png':

                    $image_create_func = 'imagecreatefrompng';

                    $image_save_func = 'imagepng';

                    $new_image_ext = 'png';

                    break;



            case 'image/gif':

                    $image_create_func = 'imagecreatefromgif';

                    $image_save_func = 'imagegif';

                    $new_image_ext = 'gif';

                    break;

    } 

    $img = $image_create_func($originalFile);

    list($width, $height) = getimagesize($originalFile);

    $tmp = imagecreatetruecolor($width, $height);

   

    if($image_create_func=="imagecreatefrompng")

    {

        imagealphablending($tmp,false);

        imagesavealpha($tmp,true);

    }



    if($newWidth < $width)

    {

        $newHeight = ($height / $width) * $newWidth;

        $tmp = imagecreatetruecolor($newWidth, $newHeight);

        if($image_create_func=="imagecreatefrompng")

        {

            imagealphablending($tmp,false);

            imagesavealpha($tmp,true);

        }

        imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        

        if (file_exists($targetFile.$name)) {

                unlink($targetFile.$name);

        }

        

      

       

        $image_save_func($tmp, "$targetFile$name");    

    self::jcphp01_generate_webp_image($targetFile.$name, 80);

    }





    }

     public static function resize_crop_image($file, $max_width, $max_height, $quality = 100)

    {
       //dd($file);
        $source_file = $_SERVER["DOCUMENT_ROOT"] . '/public/';



        $basename_img = basename($file);

        $dst_dir     = $_SERVER["DOCUMENT_ROOT"] . '/public/uploads/resize/' . $max_width . 'x' . $max_height . '/';

        

        if (!file_exists($dst_dir.basename($file)))

        {

            if ($dir = opendir($source_file)) {

                if (!file_exists($dst_dir)) {

                    mkdir($dst_dir, 0777, true);

                }

                $imgsize = getimagesize($source_file . $file);

                

                $width   = $imgsize[0];

                $height  = $imgsize[1];

                $mime    = $imgsize['mime'];

                switch ($mime) {

                    case 'image/gif':

                        $image_create = "imagecreatefromgif";

                        $image        = "imagegif";

                        break;

                    case 'image/png':

                        $image_create = "imagecreatefrompng";

                        $image        = "imagepng";

                        $quality      = 10;

                        break;

                    case 'image/jpeg':

                        $image_create = "imagecreatefromjpeg";

                        $image        = "imagejpeg";

                        $quality      = 100;

                        break;

                    default:

                        return false;

                        break;

                }

               

                $src_img    = $image_create($source_file . $file);

                $dst_img    = imagecreatetruecolor($max_width, $max_height);

                if($image_create=="imagecreatefrompng")

                {

                    imagealphablending($dst_img,false);

                    imagesavealpha($dst_img,true);

                }

                $width_new  = $height * $max_width / $max_height;

                $height_new = $width * $max_height / $max_width;

                if ($width_new > $width) {

                    $h_point = (($height - $height_new) / 2);

                    imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);

                } else {

                    $w_point = (($width - $width_new) / 2);

                    imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);

                }

                $destPath = $dst_dir .$basename_img;

                //dd( $destPath);

                $image($dst_img, $destPath, $quality);

                if ($dst_img)

                    imagedestroy($dst_img);

                if ($src_img)

                    imagedestroy($src_img);

                closedir($dir);

                // self::jcphp01_generate_webp_image($destPath, 100);

            }

        }

    }

    public static function image_size($Hinh)

    {       

        //self::resize(400,$Hinh);

        //self::resize(576,$Hinh);

        //self::resize(768,$Hinh);

       // self::resize(992,$Hinh);

       
        self::resize_crop_image($Hinh,104,156);
        self::resize_crop_image($Hinh,500,500);

   

        self::resize_crop_image($Hinh,271,271);

    }

    public static function avatar_size($Hinh)

    {       

        //self::resize(400,$Hinh);

        //self::resize(576,$Hinh);

        //self::resize(768,$Hinh);

       // self::resize(992,$Hinh);

         self::resize_crop_image($Hinh,160,240);

        self::resize_crop_image($Hinh,290,430);

       

    }

}

?>