<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Models\Terms;
use Carbon\Carbon;
use App\Helpers\Helper;
use App\Models\Posts;
use App\Models\Faq;
use App\Models\Size;
use App\Models\Color;
use App\Models\Coupon;
use App\Models\product_color_size;
use App\Models\Coupon_detail;
use App\Models\terms_posts;
use App\Models\ProductLike;
use App\Models\ReviewProduct;
use App\Models\Member;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Auth;
/*use App\Models\Order;
use App\Models\User;
use App\Models\order_product;*/
use App\Http\Lib\Order_lib;
use Illuminate\Support\Facades\App;
class PagesController extends Controller
{
    protected $Order_lib;
    public function __construct(Order_lib $Order)
    {
     
       /* $cartaaa = array(
            "cart" => Cart::content(),
            "count" =>Cart::content()->count(),
            "subtotal" => Cart::subtotal(),
            "total" => Cart::total()
        );*/
       
        $this->Order_lib = $Order;

    }
    public function getindex()
    {   
        
        //dd($menuheader);
        //$review = ReviewProduct::where("status",1)->orderByDesc("id")->limit(10)->get();
        //$cate = Terms::all();
        
        $event_term= Terms::find(df103); 

        

        $name_event =  $event_term->Name;         
        $array_child_id = Helper::user_all_childs_ids($event_term);
        array_unshift($array_child_id, $event_term->id);
        $event = Posts::with('Terms')->Wherehas('Terms',function($query) use($array_child_id){
                    $query->whereIn("id",$array_child_id);
            })->where('Post_Status',1)->take(6)->orderByDesc('created_at')->get();

        $tt_term= Terms::find(df101); 
        
        $name_tt =  $tt_term->Name;       
        $array_child_id = Helper::user_all_childs_ids($tt_term);

        array_unshift($array_child_id, $tt_term->id);

        $tt = Posts::with('Terms')->Wherehas('Terms',function($query) use($array_child_id){
                    $query->whereIn("id",$array_child_id);
            })->where('Post_Status',1)->take(6)->orderByDesc('created_at')->get();
        //dd($tt);
        return view('page.home',[
            "page"=>"trangchu","title"=>"Accueil - VNCT",
            "event" =>  $event,
            "name_event" => $name_event,
            "tt" => $tt,
            "name_tt" => $name_tt ,
            "event_term" =>$event_term,
            "tt_term" =>$tt_term  
        ]);
    }
  
    public function trangloai($slug,Request $request)
    {
        try {
        //dd(App::getLocale());
        //dd($request->input());
        $productshow = 24;
        
        if($slug=="review")
        {
                      
            $post = ReviewProduct::where("status",1)->orderByDesc("id")->limit(10)->get();
           // dd($post->toarray());
           return view('page.trangloai_review',[
                "page"=>"trangloai",
                "slug" =>$slug,
                "title"=> "Review",
                "posts" =>$post               
            ]); 
        }
        $terms= Terms::where("Slug",$slug)->get()->first();     
        $title = $terms->Name; 
        $id  =    $terms->id;        
        $bradcrumb = Helper::get_all_parent_by_id($terms);
        $sub_cate = $terms->childs;
        $showall = $terms;    
        //dd($terms->childs);
        // if($sub_cate->count()==0 && $terms->Parent > 0)
        // {
        //     $sub_cate = $terms->parents->first();
        //     $showall = $sub_cate;
        //     dd($sub_cate->toarray());
        //      $sub_cate = Terms::where("Slug",$sub_cate->Slug)->get()->first(); 
        //     $sub_cate = $sub_cate->childs;
        // }

        $array_child_id = Helper::user_all_childs_ids($terms);

        array_push($array_child_id,$terms->id);

        $post = array();
        if($terms->Taxonomy=="page")
        { 
            if($slug=="miembros")
            {
                $members = Portfolio::All();
                return view('page.trangloai_page',[
                    "page"=>"trangloai",
                    "slug" =>$slug,
                    "title"=>$title,
                    "terms"=>$terms,
                    "bradcrumb"=>$bradcrumb,
                    "members" => $members,
                    "sub_cate" => $sub_cate
                    
                ]);
            }
            else
            {
                $member_chinhthuc = [];
                $member_hoidongquantri = [];
                $vanhoaduclich = [];
                $sukiensaptoi = [];
                if($slug=="introduccion" || $slug=="gioi-thieu")
                {
                 
                   

                    
                }
                $post = Posts::where('Post_Status',1)->orderByDesc('created_at')->paginate($productshow);              
                return view('page.trangloai_page',[
                    "page"=>"trangloai",
                    "slug" =>$slug,
                    "title"=>$title,
                    "terms"=>$terms,
                    "bradcrumb"=>$bradcrumb,
                    "post" => $post,
                    "sub_cate" => $sub_cate,
                    "member_chinhthuc" => $member_chinhthuc,
                    "member_hoidongquantri" => $member_hoidongquantri,
                    // "vanhoaduclich" => $vanhoaduclich,
                    "sukiensaptoi" => $sukiensaptoi
                    
                ]);
            }
        }
        if(count($sub_cate) == 0)
        {

            $post = Posts::Wherehas('Terms',function($query) use($array_child_id){
                    $query->whereIn("id",$array_child_id);
            })->where('Post_Status',1)->orderByDesc('created_at')->paginate($productshow);
        }
        else
        {

            $post = Posts::Wherehas('Terms',function($query) use($terms){
                    $query->where("id",$terms->id);
            })->where('Post_Status',1)->orderByDesc('created_at')->paginate($productshow);
        }
        
        //Posts::where('Post_Status',1)->andwhere()->orderByDesc('updated_at')->paginate($productshow); 


        //dd($post->toarray());
        return view('page.trangloai',[
            "page"=>"trangloai",
            "slug" =>$slug,
            "title"=>$title,
            "terms"=>$terms,
            "bradcrumb"=>$bradcrumb,
            "posts"=>$post,
            "sub_cate" => $sub_cate,
            "showall" => $showall
           
        ]);
        } catch (\Exception $e) {
            return redirect('/');
        }
    }
    public function ajaxLoadPosts(Request $request)
    {
        ob_start(); // Gom HTML lại như echo trong ví dụ bạn dùng

        $id = $request->get('cate', 0);
        $page = $request->get('page', 1);
        $limit = 6; // số bài mỗi lần load

        $query = \App\Models\Posts::whereHas('Terms', function($query) use ($id) {
                $query->where('id', $id);
            })
            ->where('Post_Status', 1)
            ->orderByDesc('created_at');

        // Lấy thêm 1 bài để kiểm tra còn bài không
        $posts = $query->skip(($page - 1) * $limit)->take($limit + 1)->get();

        $hasMore = $posts->count() > $limit;
        $posts = $posts->take($limit);

        if ($page == 1 && $posts->count() > 0) {
            echo '<h2 class="title_h1 color-blue h4 mb-3 px-3">'.e($request->get('name')).'</h2>';
        }
        echo '<div class="row" >';
        foreach ($posts as $post) {
            echo '<div class="col-12 col-md-6 col-lg-4 mb-4">';
            echo \App\Helpers\Helper::template_tintuc($post);
            echo '</div>';
        }

        $html = ob_get_clean();

        // Trả về JSON để JS xử lý load more
        return response()->json([
            'html' => $html,
            'hasMore' => $hasMore,
            'nextPage' => $page + 1,
        ]);
    }

     public function trangchitiet($slug)
    {
        try{
      //dd(Cart::content());
        $post= Posts::with('Terms')->where("Post_Name",$slug)->get()->first();  
        if(Session::has('viewpost'))
        {
            if(in_array($post->id, Session::get('viewpost')))
            {
                 
            }
           else
           {
                $viewpost = Session::get('viewpost');
                array_push($viewpost, $post->id);
                Session::put('viewpost',$viewpost);
                $post->View = $post->View + 1;
                $post->save();
           }
           
        }
        else
        {
            $viewpost = array();
            array_push($viewpost, $post->id);
            Session::put('viewpost',$viewpost);
            $post->View = $post->View + 1;
                $post->save();
        }
       
             
        $title = $post->Post_Title; 
        $brand = $post->brands_id;
        $id  =    $post->id;          
        $terms = $post->terms[0]; 
        $all_terms =  $post->terms()->get(["id"]); 
        $array_items = array();  
        foreach ($all_terms as $key => $v) {
           array_push($array_items,$v->id);
        }      
        $post_lienquan = Posts::wherehas('Terms',function ($query) use ($array_items) {
            $query->whereIn('id',$array_items);
        })->where('id','<>',$post->id)->with('color')->get();       
        $dt = Carbon::now();
        $bradcrumb = Helper::get_all_parent_by_id($terms);   
        //$review =  ReviewProduct::where("posts_id",$post->id)->where("status",1)->orderByDesc("updated_at")->get();
        //$review_limit =  ReviewProduct::where("posts_id",$post->id)->where("status",1)->orderByDesc("updated_at")->limit(10)->get();
        //$avg_review = $post->review()->where("status",1)->avg('Start');
        //dd($avg_review);
        //dd($review->toarray());
        $array_coupon = collect([]);
        return view('page.trangchitiet',[
            "page"=>"trangchitiet",
            "title"=>$title,
            "terms"=>$terms,
            "bradcrumb"=>$bradcrumb,
            "posts"=>$post,
            "coupon"=>$array_coupon,
            "post_lienquan"=>$post_lienquan ,
            //"review" =>$review,
            //"avg_review" =>$avg_review ,
            //"review_limit"=>$review_limit        
        ]);
        } catch (\Exception $e) {
            return redirect('/');
        }
    }
    
    public function get_size(int $idcolor,int $idpost)
    {
         $idpost  = $idpost;
                    $idpost = substr($idpost,5);
                    $idpost = substr($idpost,0,-7);
        $post = Posts::where("id",(int)$idpost)->get()->first();      
       $size = $post->Size()->wherePivot("colors_id",(int)$idcolor)->get()->toArray();
        return $size;
    }
    public function get_color_by_id(Color $id)
    {
        return $id->Name;
    }
    public function get_size_by_id(Size $id)
    {
        return $id->Name;
    }

    public function order(Request $request)
    {
        parse_str($request->info, $output);
        $cart = json_decode (json_encode (Session::get('shopcart')), FALSE);  
       
        
        if($cart!=null)
        {
           
            $ketqua = $this->Order_lib->insert($output,$cart);       
            $array = [           
                "sussess" => $ketqua
            ];
             Session::forget("shopcart");
        }
        else
        {
           $array = [           
                "sussess" => "rong"
            ]; 
        }       
        return $array;
    }
    public function getproduct_byid(Request $request)
    {
          $id  = $request->input("id");
                    $id = substr($id,5);
                    $id = substr($id,0,-7);
        $post= Posts::where("id",$id)->get()->first();

        return view('page.trangchitiet_popup',[
            "page"=>"trangchitiet",            
            "posts"=>$post                    
        ]);
       
    }
    public function wishlist(Request $request)
    {
        if(Auth::check())
        {
           if(Session::has('wishlists'))
               {
                    $wishlist =  Session::get('wishlists');          
                    $id  = $request->id;
                    $id = substr($id,5);
                    $id = substr($id,0,-7);
                    $id_product = $id;
                    $check = true;
                    foreach ($wishlist as $key => $v) {
                        $id2  = $v;
                        $id2 = substr($id2,5);
                        $id2 = substr($id2,0,-7);
                        if($id==$id2)
                        {
                            array_splice($wishlist,$key,1);

                            $check = false;
                             ProductLike::where("posts_id",$id)->where("users_id",Auth::user()->id)->delete();
                        }
                    }         
                    if($check)
                    {
                         array_push($wishlist, $request->id);
                        ProductLike::Create([
                            "users_id" => Auth::user()->id,
                            "posts_id" => $id_product
                        ]);
                    }           
                    Session::put('wishlists',$wishlist);
               }
               else
               {
                    $wishlist = array();
                    array_push($wishlist, $request->id);
                    Session::put('wishlists',$wishlist);
               }

            return array(
            "count" => count($wishlist)
            ); 
        }
        else
        {
               if(Session::has('wishlists'))
               {
                    $wishlist =  Session::get('wishlists');          
                    $id  = $request->id;
                    $id = substr($id,5);
                    $id = substr($id,0,-7);
                    $check = true;
                    foreach ($wishlist as $key => $v) {
                        $id2  = $v;
                        $id2 = substr($id2,5);
                        $id2 = substr($id2,0,-7);
                        if($id==$id2)
                        {
                            array_splice($wishlist,$key,1);
                            $check = false;
                        }
                    }         
                    if($check)
                    {
                         array_push($wishlist, $request->id);
                    }           
                    Session::put('wishlists',$wishlist);
               }
               else
               {
                    $wishlist = array();
                    array_push($wishlist, $request->id);
                    Session::put('wishlists',$wishlist);
               }
             }
       return array(
            "count" => count($wishlist)
       );
    }
    public function wishlists()
    {
        //Session::put('wishlists',[]);
        dd(Session::get('wishlists'));
    }
    public function review(Request $request)
    {
        
       if ($request->hasFile('image')) {

            $request->validate([
                    'author' => 'string|max:500',
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
                ]);
                
                 $imageName = time().'.'.$request->image->extension();  
                 $request->image->move(public_path('uploads/review/'), $imageName);
                 $id  = $request->input('product');
                    $id = substr($id,5);
                    $id = substr($id,0,-7);
                 ReviewProduct::Create([
                    "Image" => $imageName,
                    "Name" => $request->input('author'),
                    "Start" => (int)$request->input('rating'),
                    "Content" => $request->input('comment'),
                    "colors_id" => $request->input('color'),
                    "posts_id" => $id,
                    "users_id" => (Auth::check())? Auth::user()->id : NULL
                 ]);
                 //dd($request->input());
                Session::flash('success', "Cảm ơn bạn đã đánh giá. đánh giá của bạn đã được gửi tới chúng tôi");
                return \Redirect::back();
           
        }
        else
        {
             $request->validate([
                    'author' => 'string|max:500',                    
             ]);
             $id  = $request->input('product');
                    $id = substr($id,5);
                    $id = substr($id,0,-7);
                 ReviewProduct::Create([                  
                    "Name" => $request->input('author'),
                    "Start" => (int)$request->input('rating'),
                    "Content" => $request->input('comment'),
                    "colors_id" => $request->input('color'),
                    "posts_id" => $id,
                    "users_id" => (Auth::check())? Auth::user()->id : NULL
                 ]);
                 //dd($request->input());
                Session::flash('success', "Cảm ơn bạn đã đánh giá. đánh giá của bạn đã được gửi tới chúng tôi");
                return \Redirect::back();
        }
    }
    public function loadmore_review(Request $request)
    {
        $avg_review= 0;
         $count_review = 0;
        if($request->id)
        {
                    $id_product  = $request->id;
                    $id_product = substr($id_product,5);
                    $id_product = substr($id_product,0,-7);
                     $review =  ReviewProduct::where("posts_id",$id_product)->where("status",1)->orderByDesc("id")->where("id","<",$request->id_review)->where('colors_id',$request->id_color)->limit(10)->get(); 
                $avg_review = ReviewProduct::where("posts_id",$id_product)->where("status",1)->where('colors_id',$request->id_color)->avg('Start');
                $review_count =  ReviewProduct::where("posts_id",$id_product)->where("status",1)->orderByDesc("created_at")->where("id","<",$request->id_review)->where('colors_id',$request->id_color)->get();
                $count_review =  $review_count->count();
        }
        else
        {
            $review =  ReviewProduct::where("status",1)->orderByDesc("id")->where("id","<",$request->id_review)->limit(10)->get();  
        }
      
       $str='';
       $last_id = 0;
       foreach ($review as $key => $v) {
         $str.=' <div class="grid-item " onclick="popup_review('.$v->id.')">';
                         $str.=' <div id="comment-20" class="comment_container"> ';
                             if ($v->Image!="")
                             {
                               $str.='<img src="/uploads/review/'.$v->Image.'" >';
                             }
                           $str.=' <div class="comment-text">';
                             $str.=' <p class="meta"> ';
                               $str.=' <strong class="woocommerce-review__author">'. $v->Name.'</strong> ';
                               $str.=' <span class="woocommerce-review__dash">–</span>';
                               $str.='<time class="woocommerce-review__published-date" datetime="2008-02-14 20:00">'.$v->created_at->format(
                                'F d, Y'
                            ).'</time>';
                             $str.=' </p>';
                             $str.=' <div class="star-rating">';
                                $str.='<span style="width: '.$v->Start * 20 .'%;">Rated <strong class="rating">5</strong> out of 5</span>';
                             $str.=' </div>';
                              
                             $str.=' <div class="description">';
                              $str.='   <p>'.$v->Content.'</p>';
                            $str.='  </div>';
                             
                              
                           $str.=' </div>';
                         $str.=' </div>';
                      $str.='  </div>';
            $last_id = $v->id;
       }
      /* if($last_id>0)
       {
       $str.='<div class="buttonaddreview  mb-3" data-id="'.$last_id.'"  onclick="loadmore_review(this,'.$request->id.')">Xem Thêm</div>';
        }*/
       return array(
            "content"=> $str,
            "last_id"=> $last_id,
            'avg_review' =>$avg_review,
            "count_review" => $count_review
       );
   }

   public function review_info(Request $request)
   {
        $review = ReviewProduct::find($request->id);
        $str = "";
        $str.='<div class="row ">';
        if(!is_null($review->Image))
        {
            $str.='<div class="col-12 col-lg-6 d-flex justify-content-center align-items-center">';
            $str.='<img src="/uploads/review/'.$review->Image.'" >';
            $str.='</div>';
            $str.='<div class="col-12 col-lg-6" style="display: flex;   ">';
            $str.='<div class="comment-text" style="flex-basis: 100%;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: stretch;">
                              <p class="meta"> 
                                <strong class="woocommerce-review__author">'.$review->Name.'</strong> 
                                <span class="woocommerce-review__dash">–</span>
                                <time class="woocommerce-review__published-date" datetime="'.$review->created_at->format('F d, Y').'">'. $review->created_at->format('F d, Y') .'</time>
                              </p>
                              <div class="star-rating">
                                <span style="width: '. $review->Start * 20 .'%;">Rated <strong class="rating">5</strong> out of 5</span>
                              </div>
                              
                              <div class="description" style="    flex-grow: 1;">
                                <p>'. $review->Content.'</p>
                              </div>
                              ';
                              
                                  $product = $review->product;
                                 $color = product_color_size::where('posts_id',$product->id)->where('colors_id',$review->colors_id)->limit(1)->get();
                                 $product_img =  explode(",", $color[0]->Album);
                                 //dd($color->toarray());
                             
             $str.='<div class="description des_popup_review">
             <hr>
                                <div class="row">
                                    <div class="col-3">
                                       <img src="'.$product_img[0].'" >
                                    </div>
                                    <div class="col">
                                        '. $product->Post_Title.'
                                        <a class="btn btn-light mt-3" href="/'.$product->Post_Name.'.html" >View product <i class="fa fa-eye" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                              </div>
                              
                            </div>';
            $str.='</div>';
        }
        else
        {
           $str.='<div class="col-12">';
         $str.='<div class="comment-text">
                              <p class="meta"> 
                                <strong class="woocommerce-review__author">'.$review->Name.'</strong> 
                                <span class="woocommerce-review__dash">–</span>
                                <time class="woocommerce-review__published-date" datetime="'.$review->created_at->format('F d, Y').'">'. $review->created_at->format('F d, Y') .'</time>
                              </p>
                              <div class="star-rating">
                                <span style="width: '. $review->Start * 20 .'%;">Rated <strong class="rating">5</strong> out of 5</span>
                              </div>
                              
                              <div class="description">
                                <p>'. $review->Content.'</p>
                              </div>
                              ';
                              
                                  $product = $review->product;
                                 $color = product_color_size::where('posts_id',$product->id)->where('colors_id',$review->colors_id)->limit(1)->get();
                                 $product_img =  explode(",", $color[0]->Album);
                                 //dd($color->toarray());
                             
             $str.='<div class="description des_popup_review">
             <hr>
                                <div class="row">
                                    <div class="col-3">
                                       <img src="'.$product_img[0].'" >
                                    </div>
                                    <div class="col">
                                       <div> '. $product->Post_Title.'</div>
                                        <a class="btn btn-light mt-3" href="/'.$product->Post_Name.'.html" >View product <i class="fa fa-eye" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                              </div>
                              
                            </div>';
           $str.='</div>'; 
        }
        
        $str.='</div>';
        return array(
            "Content"=>$str
        );
   }

  




    public function getallparent($subcategory)
    {
        $append = array();
        if (count($subcategory->subcategory)) {
            array_push($append, $subcategory->id);
            $this->getallparent($subcategory->subcategory);
        } else {
            array_push($append, $subcategory->id);
        }
        return $append;
    }
    public function getPost($slug)
    {
        $post = Post::where('status', 1)->where('slug', $slug)->first();
        if (count($post) == 0) {
            return view('news.pages.singlepost', ['key' => $slug]);
        } else {
            $post->view = $post->view + 1;
            $post_lq = Post::where('status', 1)->where('slug', '!=', $slug)->where('category_id', '=', $post->category_id)->take(5)->get();
            $post->save();
            return view('news.pages.singlepost', ['post' => $post, 'lq' => $post_lq]);
        }
    }
    public function getTag($key)
    {
        $tag = Tag::where('name', $key)->first();
        if (count($tag) == 0 || count($tag->posts) == 0) {
            return view('news.pages.tag', ['key' => $key]);
        } else
            return view('news.pages.tag', ['tag' => $tag]);
    }
    public function getSearch(Request $request)
    {
        $key = $request->input('key');
        $posts = Post::where('status', 1)->where('title', 'like', '%' . $key . '%')->get();
        return view('news.pages.search', ['posts' => $posts, 'key' => $key]);
    }
    public function getAuthor($user)
    {
        $author = Admin::where('name', $user)->first();
        if (count($author) == 0 || count($author->posts) == 0) {
            return view('news.pages.author', ['key' => $user]);
        } else
            return view('news.pages.author', ['author' => $author]);
    }
    public function getContact()
    {
        return view('news.pages.contact');
    }
}
