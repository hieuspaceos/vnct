
<?php 

$content = $danhmuc->Content;

$check_validate = true;

 
if(\Illuminate\Support\Str::contains($content, '[newin]'))
{
	$check_validate = false;
	$str=''; 
	if($page=="trangchu")
	{
		$str.='<div class=" slide-sanpham owl-carousel owl-theme  "  id="slide-sanpham-'.$v.'">';	
		$post = App\Models\Posts::where('Post_Status',1)->orderByDesc('created_at')->limit(10)->get();	
		foreach ($post as $v_post)
		{
			$str.= View::make('blocks.layout_sanpham_home', array('v_post' => $v_post));
		}
		$str.='</div>';	
	}
	else if($page=="trangloai")
	{
		$str.='<div class="row"  >';	
		$post = App\Models\Posts::where('Post_Status',1)->paginate(12);	
		foreach ($post as $v_post)
		{
			$str.= "<div class='col-6 col-lg-3'>".View::make('blocks.layout_sanpham_home', array('v_post' => $v_post))."</div>";
		}
		$str.='</div>';
		$str.='<div class="d-flex justify-content-center "> 
			'.$post->appends(request()->input())->links();
		$str.='</div>'	;	
	}
	$content= str_replace("[newin]",$str , $content);		
}

if(\Illuminate\Support\Str::contains($content, '[discount]'))
{
	$check_validate = false;
	$str=''; 
	if($page=="trangchu")
	{
		$str.='<div class=" slide-sanpham owl-carousel owl-theme  "  id="slide-sanpham-'.$v.'">';	
		$post = App\Models\Posts::wherehas("Color",function($query){
            $query->Where("price_sale",">",0);
        })->orderByDesc('created_at')->limit(10)->get();	
		foreach ($post as $v_post)
		{
			$str.= View::make('blocks.layout_sanpham_home', array('v_post' => $v_post));
		}
		$str.='</div>';	
	}
	else if($page=="trangloai")
	{
		$str.='<div class="row"  >';	
		$post = App\Models\Posts::wherehas("Color",function($query){
            $query->Where("price_sale",">",0);
        })->paginate(12);	
		foreach ($post as $v_post)
		{
			$str.= "<div class='col-6 col-lg-3'>".View::make('blocks.layout_sanpham_home', array('v_post' => $v_post))."</div>";
		}
		
		$str.='</div>';	
		$str.='<div class="d-flex justify-content-center "> 
			'.$post->appends(request()->input())->links();
		$str.='</div>'	;
	}	
	$content= str_replace("[discount]",$str , $content);	
}

if(\Illuminate\Support\Str::contains($content, '[highlight]'))
{
	$check_validate = false;
	$str=''; 
	if($page=="trangchu")
	{
		$str.='<div class=" slide-sanpham owl-carousel owl-theme  "  id="slide-sanpham-'.$v.'">';	
		$post = App\Models\Posts::orderByDesc('View')->limit(10)->get();	
		foreach ($post as $v_post)
		{
			$str.= View::make('blocks.layout_sanpham_home', array('v_post' => $v_post));
		}
		$str.='</div>';	
	}
	else if($page=="trangloai")
	{
		$str.='<div class="row"  >';	
		$post = App\Models\Posts::orderByDesc('View')->paginate(12);	
		foreach ($post as $v_post)
		{
			$str.= "<div class='col-6 col-lg-3'>".View::make('blocks.layout_sanpham_home', array('v_post' => $v_post))."</div>";
		}
		
		$str.='</div>';	
		$str.='<div class="d-flex justify-content-center "> 
			'.$post->appends(request()->input())->links();
		$str.='</div>'	;
	}	
	$content= str_replace("[highlight]",$str , $content);	
}
	
echo'<section class="section_2 py-5" style="'.$bg.'">';

echo'<Div class="container">';
	if($page=="trangchu" && !$check_validate)
	{
	    echo'<div class="row">';

	    echo'<div class="col-md-12 col-lg-12 mb-2">';

	    echo'<div class="card-title title_h2 h2 text-center">   <a  href="'.$danhmuc->Slug.'" style="color:inherit; '.$bg.'"> 

							 '.$danhmuc->Name.'</a>';
		echo' </div>';
		echo'</div>';

	    echo'</div>';
	}
echo'<div class="row">';

echo'<div class="col-12">';	
	echo $content;	

	echo'</div>';

	echo'</div>';
	//$str.='<div class="text-center pt-4" > <a href="'.$danhmuc->Slug.'/" style="color:#fff" class="btn background_vang" >Xem tất cả </a></div>';
	echo'</Div>';

	echo'</section>';	
?>