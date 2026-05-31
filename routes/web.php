<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\MailerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\admin\Donhang;
use App\Http\Controllers\admin\FaqController;
use App\Http\Controllers\admin\Coupons;
use App\Http\Controllers\admin\ContactController;
use App\Http\Controllers\admin\ReviewController;
use App\Http\Controllers\admin\PopupController;
use App\Http\Controllers\admin\UsesnewsController;
use App\Http\Controllers\admin\MemberController;
use App\Http\Controllers\admin\PortfolioController;
use App\Http\Controllers\admin\UserControllerAdmin;
use App\Http\Controllers\admin\BusinessController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BusinessAuthController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\language;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\App;
use App\Http\Middleware\Auth_admin;
use App\Http\Middleware\Is_admin;
use App\Http\Middleware\Is_login;
use Illuminate\Support\Facades\DB;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Routes cho doanh nghiệp
Route::prefix('business')->name('business.')->group(function () {
    Route::get('/login', [BusinessAuthController::class, 'showForm'])->name('login.form');
    Route::post('/register', [BusinessAuthController::class, 'register'])->name('register');
    Route::post('/login', [BusinessAuthController::class, 'login'])->name('login');
    
    Route::get('/logout', [BusinessAuthController::class, 'logout'])->name('logout');
});
    // Route::get('/register', [RegisterController::class,"showRegistrationForm"])->name('register');
    // Route::get('/login', function () {
    //     return view('auth.login');
    // })->name('login');

Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');

Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
    ->name('ckfinder_browser');


    
Route::get('getcateandproduct', [ProductController::class,'index'])->name("getall");
Route::get('abc/bch',function(){
	dd(bcrypt("admin!@123"));
});
Route::get('xoacache/abc',function(){
	Session::forget('cart_coupon_coupon');
		Session::forget('shopcart');
});
//gio hang
Route::prefix('carts')->group(function(){
	Route::post("",[CartController::class,'carts']);
	Route::get("removeallcarts",function(){	
		Cart::instance('cart')->destroy();		
		Session::forget('cart_coupon_coupon');
		Session::forget('shopcart');
	});
	Route::post("removebyid",[CartController::class,'removebyid']);
	Route::post("update_cart",[CartController::class,'update_cart']);
	Route::post("update_coupon",[CartController::class,'update_coupon']);
	Route::post("update_coupon_single",[CartController::class,'update_coupon_single']);
	Route::post("addcart",[CartController::class,'addcart']);
});

Route::prefix('admin')->group(function(){
	
	Route::middleware(Auth_admin::class)->group(function () {

		Route::get('',[PageController::class,'index'])->name('main_admin');

		Route::get('api/categories', function(Request $request) {
		  $results = DB::table('terms')
		    ->where('Taxonomy', 'tintuc')
		    ->where('Name', 'like', '%' . $request->q . '%')
		    ->where('lang', App::currentLocale())
		    ->limit(20)
		    ->get();

		  $formattedData = $results->map(function ($item) {
		    return [
		      'id' => $item->id,
		      'text' => $item->Name
		    ];
		  });

		  return response()->json([
		    'results' => $formattedData,
		    'pagination' => ['more' => false]
		  ]);
		})->name('api.categories');

        // ----------------------------------------------------------------
        // 2. API: Tin tức (news_post)
        // ----------------------------------------------------------------
        Route::get('api/news', function(Request $request) {
		  $results = DB::table('posts')
		    ->where('Post_Type', 'tintuc')
		    ->where('Post_Title', 'like', '%' . $request->q . '%')
		    ->where('lang', App::currentLocale())
		    ->limit(20)
		    ->get();

		  $formattedData = $results->map(function ($item) {
		    return [
		      'id' => $item->id,
		      'text' => $item->Post_Title // Lấy tiêu đề bài viết
		    ];
		  });

		  return response()->json([
		    'results' => $formattedData,
		    'pagination' => ['more' => false]
		  ]);
		})->name('api.news'); // <-- Đảm bảo tên route là 'api.news'

        // ----------------------------------------------------------------
        // 3. API: Trang (page)
        // ----------------------------------------------------------------
        Route::get('api/pages', function(Request $request) {
		  $results = DB::table('terms') // Dùng bảng terms như bạn đã làm
		    ->where('Taxonomy', 'page')
		    ->where('Name', 'like', '%' . $request->q . '%')
		    ->where('lang', App::currentLocale())
		    ->limit(20)
		    ->get();

		  $formattedData = $results->map(function ($item) {
		    return [
		      'id' => $item->id,
		      'text' => $item->Name // Lấy tên trang
		    ];
		  });

		  return response()->json([
		    'results' => $formattedData,
		    'pagination' => ['more' => false]
		  ]);
		})->name('api.pages'); // <-- Đảm bảo tên route là 'api.pages'
        Route::middleware(Is_admin::class)->group(function () {
        	Route::resource('users', UserControllerAdmin::class);
    	});
        
		Route::resource('members', MemberController::class);
		Route::get('members/copy-lang/{lang}/{member}', [MemberController::class, 'copyLang']);
		Route::resource('portfolio', PortfolioController::class);
		Route::get('portfolio/copy-lang/{lang}/{portfolio}', [PortfolioController::class, 'copyLang']);
		//popup
		Route::prefix('popup')->group(function(){
			Route::get('list',[PopupController::class,'popup_list'])->name('popup_list');
			Route::get('add',[PopupController::class,'popup_add']);
			Route::post('add',[PopupController::class,'popup_add_store']);
			Route::get('edit/{id}',[PopupController::class,'popup_edit']);
			Route::post('edit/{id}',[PopupController::class,'popup_edit_store']);
			Route::get('delete/{id}',[PopupController::class,'popup_delete']);
		});
		//Faq
		Route::prefix('faq')->group(function(){
			Route::get('list',[FaqController::class,'faq_list'])->name('faq_list');
			Route::get('add',[FaqController::class,'faq_add']);
			Route::post('add',[FaqController::class,'faq_add_store']);
			Route::get('edit/{id}',[FaqController::class,'faq_edit']);
			Route::post('edit/{id}',[FaqController::class,'faq_edit_store']);
			Route::post('update_order',[FaqController::class,'faq_update_order']);
			Route::get('delete/{id}',[FaqController::class,'faq_delete']);
		});
		Route::prefix('contact')->group(function(){
			Route::get('list',[ContactController::class,'Contact_list'])->name('contact_list');
			Route::get('see/{id}',[ContactController::class,'Contact_see']);			
		});
		Route::prefix('review')->group(function(){
			Route::get('list',[ReviewController::class,'Review_list'])->name('review_list');
			Route::post('update',[ReviewController::class,'Review_update']);
			Route::get('delete/{id}',[ReviewController::class,'Review_delete']);			
		});
		//danh mục
		Route::prefix('danhmuc')->group(function(){

			Route::get('list',[PageController::class,'danhmuc_list'])->name('danhmuc_list');;
			Route::get('add',[PageController::class,'danhmuc_add']);
			Route::post('add',[PageController::class,'danhmuc_add_store']);
			Route::get('edit/{id}',[PageController::class,'danhmuc_edit']);
			Route::post('edit/{id}',[PageController::class,'danhmuc_edit_store']);
			Route::get('copy-lang/{lang}/{id}',[PageController::class,'danhmuc_copy_lang']);
			Route::get('delete/{id}',[PageController::class,'danhmuc_delete']);
		});
		//product
		Route::prefix('product')->group(function(){
			Route::get('list',[PageController::class,'product_list'])->name('sanpham');
			Route::get('add',[PageController::class,'product_add']);
			Route::post('add',[PageController::class,'product_add_store']);
			Route::get('edit/{id}',[PageController::class,'product_edit']);
			Route::post('edit/{id}',[PageController::class,'product_edit_store']);
			Route::get('copy/{id}',[PageController::class,'product_copy']);
			Route::get('delete/{id}',[PageController::class,'product_delete']);
			// color
			Route::get('list_color',[PageController::class,'product_list_color']);
			Route::get('add_color',[PageController::class,'product_add_color']);
			Route::post('add_color',[PageController::class,'product_add_store_color']);
			Route::post('insert_color',[PageController::class,'insert_color']);
			Route::get('edit_color/{id}',[PageController::class,'product_edit_color']);
			Route::post('edit_color/{id}',[PageController::class,'product_edit_store_color']);
			Route::get('delete_color/{id}',[PageController::class,'product_delete_color']);
			Route::get('get_list_color',[PageController::class,'get_list_color']);
			// size
			Route::get('list_size',[PageController::class,'product_list_size']);
			Route::get('add_size',[PageController::class,'product_add_size']);
			Route::post('add_size',[PageController::class,'product_add_store_size']);
			Route::post('insert_size',[PageController::class,'insert_size']);
			Route::get('edit_size/{id}',[PageController::class,'product_edit_size']);
			Route::post('edit_size/{id}',[PageController::class,'product_edit_store_size']);
			Route::get('delete_size/{id}',[PageController::class,'product_delete_size']);
			Route::get('get_list_size',[PageController::class,'get_list_size']);
		});
		//bài viết
		Route::prefix('baiviet')->group(function(){
			Route::get('list',[PageController::class,'baiviet_list']);
			Route::get('add',[PageController::class,'baiviet_add']);
			Route::post('add',[PageController::class,'baiviet_add_store']);
			Route::get('edit/{id}',[PageController::class,'baiviet_edit']);
			Route::post('edit/{id}',[PageController::class,'baiviet_edit_store']);
			Route::get('copy/{id}',[PageController::class,'baiviet_copy']);
			Route::get('copy-lang/{lang}/{id}',[PageController::class,'baiviet_copy_lang']);
			Route::get('delete/{id}',[PageController::class,'baiviet_delete']);
		});
		//coupon
		Route::prefix('coupons')->group(function(){
			Route::get('list',[Coupons::class,'coupon_list'])->name('coupon');;
			Route::get('add',[Coupons::class,'coupon_add']);
			Route::post('add',[Coupons::class,'coupon_add_store']);
			Route::post('update_usepopup',[Coupons::class,'update_usepopup']);
			Route::get('edit/{id}',[Coupons::class,'coupon_edit']);
			Route::post('edit/{id}',[Coupons::class,'coupon_edit_store']);
			Route::get('delete/{id}',[Coupons::class,'coupon_delete']);
		});

		//Đon Hàng
		Route::prefix('donhang')->group(function(){
			Route::get('list',[Donhang::class,'donhang_list'])->name('donhang');
			Route::get('add',[Donhang::class,'donhang_add']);
			Route::post('add',[Donhang::class,'donhang_add_store']);
			Route::get('edit/{id}',[Donhang::class,'donhang_edit']);
			Route::post('edit/{id}',[Donhang::class,'donhang_edit_store']);
			Route::get('delete/{id}',[Donhang::class,'donhang_delete']);
		});
		//Config
		Route::prefix('config')->group(function(){
			Route::get('list',[PageController::class,'config_list']);
			Route::post('edit',[PageController::class,'config_edit']);			
		});
		// ngôn ngữ
		Route::get('language/{lang}',function($lang){
			$id = language::where("Name",$lang)->get()->first();	
			App::setLocale($id->id);
			 Session::put('language', $id->id);
			//dd(App::currentLocale());
			return redirect()->route('main_admin');
		});
		Route::get('/businesses', [BusinessController::class, 'index'])->name('businesses.index');
	    Route::get('/businesses/{id}', [BusinessController::class, 'show'])->name('businesses.show');
	    Route::post('/businesses/{id}/approve', [BusinessController::class, 'approve'])->name('businesses.approve');
	    Route::post('/businesses/{id}/reject', [BusinessController::class, 'reject'])->name('businesses.reject');
	    Route::delete('/businesses/{id}', [BusinessController::class, 'destroy'])->name('businesses.destroy');
	    Route::get('/businesses-stats', [BusinessController::class, 'stats'])->name('businesses.stats');
	});	
	Route::get('logout',function(){
		Session::flush();        
        Auth::logout();
        return redirect()->route('login_admin');
	});
	Route::get('login',[PageController::class,'login'])->name('login_admin');
	Route::post('checklogin',[PageController::class,'checklogin']);
});

// Login Web 
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->get('user/donhang', [UserController::class,'show'])->name('donhang.show');
Route::middleware(['auth:sanctum', 'verified'])->get('user/donhang/{id}', [UserController::class,'seen'])->name('donhang.seen');

// Route::any('/test-ckfinder-connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction');




//login facebook
Route::get('auth/facebook', [SocialController::class, 'facebookRedirect']);
Route::get('auth/facebook/callback', [SocialController::class, 'loginWithFacebook']);
Route::get("Facebook/callback",function(){
	return "ok";
});
// ngôn ngữ
Route::get('language/{lang}',function($lang){
	$id = language::where("Name",$lang)->get()->first();	
	App::setLocale($id->id);
	 Session::put('language', $id->id);
	  Session::put('languages',$id->Name);
    Session::put('languagess',$id->Name);
	//dd(App::currentLocale());
	return redirect()->route('home');
});
Route::get('languages/{lang}',function($lang){
	$id = language::where("Name",$lang)->get()->first();	
	App::setLocale($id->id);
	 Session::put('language', $id->id);
    Session::put('languages',$id->Name);
    Session::put('languagess',$id->Name);
	//dd(App::currentLocale());
	if(request()->has('redirect')) {
        return redirect(request()->redirect);
    }
	return redirect()->back();
})->name('admin.changelanguages');
// routes/web.php
Route::post('/update-language-session', function(Request $request){
	$locale = $request->input('language');    
        if (in_array($locale, ['vi', 'fr', 'en', 'es'])) {
            Session::put('languages', $locale);
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 400);

})->name('language.update.session');
Route::get('handle-language/{locale}', function (Request $request, $locale) {
    $currentUrl = $request->query('current_url');
    $path = parse_url($currentUrl, PHP_URL_PATH);
    $segments = explode('/', trim($path, '/'));
   
    // Gán mã ID ngôn ngữ tương ứng trong DB của bạn
    // Giả sử: vi = 1, fr = 2
    $langId = language::where("Name",$locale)->get()->first();
    $langId = $langId->id;    
    App::setLocale($langId);
	Session::put('language',$langId);
    Session::put('languages',$locale);
    Session::put('languagess',$locale);

    // Nếu URL ngắn (trang chủ) hoặc không có segment
    if (empty($segments) || (count($segments) == 1 && in_array($segments[0], ['vi', 'fr', 'en', 'es']))) {
        return redirect()->to($locale == 'vi' ? '/' : '/fr');
    }

    // Lấy slug (thường là phần cuối cùng của URL)
    $slug = end($segments);
    $slug_post = preg_replace("/\.html$/", "", end($segments));
    
    // 1. Kiểm tra nếu là Post (Dựa trên tên cột Post_Name của bạn)
    $post = DB::table('posts')->where('Post_Name', $slug_post)->first();
    //dd($post);
    if ($post) {
        $oid = $post->origin_id ?: $post->id;
        $translated = DB::table('posts')->where('lang', $langId)
            ->where(function($q) use ($oid) {
                $q->where('id', $oid)->orWhere('origin_id', $oid);
            })->first();

        if ($translated) {
        	//dd($translated->Post_Name);
            return redirect()->to("{$translated->Post_Name}.html");
        }
    }

    // 2. Kiểm tra nếu là Danh mục (Dựa trên tên cột Slug của bạn)
    $term = DB::table('terms')->where('Slug', $slug)->first();
    if ($term) {
        $oid = $term->origin_id ?: $term->id;
        $translated = DB::table('terms')->where('lang', $langId)
            ->where(function($q) use ($oid) {
                $q->where('id', $oid)->orWhere('origin_id', $oid);
            })->first();

        if ($translated) {
            return redirect()->to("{$translated->Slug}");
        }
    }

    // Nếu không tìm thấy gì thì về trang chủ của ngôn ngữ đó
    return redirect()->to('/');
})->name('lang.handle');

Route::get('/clone-members', function () {
    // 1. Lấy tất cả các dòng đang là ngôn ngữ 1
    $originals = DB::table('members')->where('lang', 1)->get();
    
    $count = 0;
    
    foreach ($originals as $item) {
        // 2. Kiểm tra xem đã tồn tại bản dịch lang = 2 cho dòng này chưa để tránh duplicate nếu chạy lại route lần 2
        $exists = DB::table('members')
            ->where('origin_id', $item->id)
            ->where('lang', 2)
            ->exists();

        if (!$exists) {
            // 3. Thực hiện copy
            DB::table('members')->insert([
                'name'      => $item->name,
                'slug'     => $item->slug.'-vi' , // Thêm hậu tố để bạn dễ kiểm tra trong DB
                'lang'       => 2,           // Ngôn ngữ mới
                'origin_id'  => $item->id,    // Liên kết với ID dòng gốc
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $count++;
        }
    }

    return "Thành công! Đã sao chép $count dòng mới sang ngôn ngữ 2.";
});

Route::get('/clone-configs', function () {
    // 1. Lấy tất cả các dòng đang là ngôn ngữ 1
    $originals = DB::table('configs')->where('lang', 1)->get();
    
    $count = 0;
    
    foreach ($originals as $item) {
        // 2. Kiểm tra xem đã tồn tại bản dịch lang = 2 cho dòng này chưa để tránh duplicate nếu chạy lại route lần 2
        $exists = DB::table('configs')
            ->where('origin_id', $item->id)
            ->where('lang', 2)
            ->exists();

        if (!$exists) {
            // 3. Thực hiện copy
            DB::table('configs')->insert([
                'Value'      => $item->Value,
                'TieuDe'     => $item->TieuDe . ' (EN)', // Thêm hậu tố để bạn dễ kiểm tra trong DB
                'Type'       => $item->Type,
                'Page'       => $item->Page,
                'define'     => $item->define,
                'thutu'      => $item->thutu,
                'lang'       => 2,           // Ngôn ngữ mới
                'origin_id'  => $item->id,    // Liên kết với ID dòng gốc
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $count++;
        }
    }

    return "Thành công! Đã sao chép $count dòng mới sang ngôn ngữ 2.";
});



Route::get('/copy-data-to-lang-2', function () {
    DB::transaction(function () {
        // 1. Copy dữ liệu từ bảng terms
        $originalTerms = DB::table('terms')
            ->where('lang', 1)
            ->get();
            
        foreach ($originalTerms as $term) {
            $newTermId = DB::table('terms')->insertGetId([
                'Name' => $term->Name,
                'Slug' => $term->Slug . '-en', // Thêm suffix để tránh trùng unique
                'Image' => $term->Image,
                'Taxonomy' => $term->Taxonomy,
                'Parent' => $term->Parent, // Lưu ý: Parent ID cần xử lý sau
                'Title' => $term->Title,
                'Description' => $term->Description,
                'keyword' => $term->keyword,
                'Content' => $term->Content,
                'vitri' => $term->vitri,
                'ThuTu' => $term->ThuTu,
                'AnHien' => $term->AnHien,
                'lang' => 2,
                'origin_id' => $term->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Map giữa ID cũ và ID mới cho việc update Parent
            $termIdMap[$term->id] = $newTermId;
        }
        
        // Update Parent cho các terms mới tạo
        foreach ($originalTerms as $term) {
            if ($term->Parent > 0 && isset($termIdMap[$term->Parent])) {
                DB::table('terms')
                    ->where('id', $termIdMap[$term->id])
                    ->update(['Parent' => $termIdMap[$term->Parent]]);
            }
        }
        
        // 2. Copy dữ liệu từ bảng posts
        $originalPosts = DB::table('posts')
            ->where('lang', 1)
            ->get();
            
        foreach ($originalPosts as $post) {
            $newPostId = DB::table('posts')->insertGetId([
                'users_id' => $post->users_id,
                'Post_Title' => $post->Post_Title,
                'Post_Status' => $post->Post_Status,
                'Post_Name' => $post->Post_Name . '-en',
                'Post_Thumb' => $post->Post_Thumb,
                'Price' => $post->Price,
                'Listed_Price' => $post->Listed_Price,
                'Sale' => $post->Sale,
                'View' => $post->View,
                'Short_Post_Content' => $post->Short_Post_Content,
                'Post_Content' => $post->Post_Content,
                'Post_Sizing' => $post->Post_Sizing,
                'Post_Returns' => $post->Post_Returns,
                'Post_Shiping' => $post->Post_Shiping,
                'Title' => $post->Title,
                'Desription' => $post->Desription,
                'Keyword' => $post->Keyword,
                'Post_Type' => $post->Post_Type,
                'lang' => 2,
                'origin_id' => $post->id,
                'brands_id' => $post->brands_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Map giữa post ID cũ và mới
            $postIdMap[$post->id] = $newPostId;
        }
        
        // 3. Copy dữ liệu từ bảng terms_posts (quan hệ nhiều-nhiều)
        $originalTermsPosts = DB::table('terms_posts')
            ->join('posts', 'terms_posts.posts_id', '=', 'posts.id')
            ->where('posts.lang', 1)
            ->select('terms_posts.*')
            ->get();
            
        foreach ($originalTermsPosts as $relation) {
            // Chỉ copy nếu cả posts_id và terms_id đều đã được copy
            if (isset($postIdMap[$relation->posts_id]) && isset($termIdMap[$relation->terms_id])) {
                DB::table('terms_posts')->insert([
                    'posts_id' => $postIdMap[$relation->posts_id],
                    'terms_id' => $termIdMap[$relation->terms_id],
                ]);
            }
        }
        
        return "Đã copy thành công dữ liệu sang ngôn ngữ 2!";
    });
});

// web 
// Route::get('testcode/abc', function() {
//    $a = Order::where('CodeOrder','DH-0000000001')->with('order_product')->get()->toArray();
//    dd($a);
  
// });

Route::get('', [PagesController::class,'getindex'])->name("home");
Route::get('ajax/load-posts', [PagesController::class, 'ajaxLoadPosts']);
Route::post('sendmail', [MailerController::class, 'SendEmail']);
Route::get('{slug}.html', [PagesController::class,'trangchitiet']);
Route::get('{slug}/', [PagesController::class,'trangloai']);
Route::post('api/review', [PagesController::class,'review']);
Route::post('api/review_info', [PagesController::class,'review_info']);
Route::post('api/loadmore_review', [PagesController::class,'loadmore_review']);
Route::post('api/search_ajax', [SearchController::class,'search_ajax']);
Route::get('tim-kiem/{key}', [SearchController::class,'search']);
Route::post('api/usernewsletter',[UsesnewsController::class,'add']);
// Route::get('model/insert_user',function(){
// 	//echo bcrypt("admin!@123");
// 	$query = new User;
// 	$query->name = "admin";
// 	$query->email = "tgsensenest@gmail.com";
// 	$query->password = bcrypt("admin!@123");
// 	$query->Level = 1;
// 	$query->save();
// 	//echo "đã thêm";
// });
Route::get('xoacache/xoa', function() {

    Artisan::call('cache:clear');
     Artisan::call('route:clear');
      Artisan::call('config:clear');
       Artisan::call('view:clear');
     echo "ok";  
});
Route::get('chaylenh/migrate', function() {
    Artisan::call('migrate');   
   
});

/*Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){

	Route::get('/', 'HomeController@getdashbroad')->name('dashbroad');
	

    /* Group post*/
   /* Route::prefix('post')->group(function () {
        Route::get('/', 'PostController@getList')->name('list-post');
        Route::get('add', 'PostController@getAdd');
        Route::put('updateStatus', 'PostController@updateStatus');
        Route::put('updateHot', 'PostController@updateHot');
        Route::post('add', 'PostController@postAdd');
        Route::get('update/{id}', 'PostController@getUpdate');
        Route::post('update/{id}', 'PostController@postUpdate');
        Route::get('delete/{id}', 'PostController@getDelete');
    });*/

     /* Group product*/
    /* Route::prefix('product')->group(function () {
        Route::get('/', 'ProductController@getList')->name('list-product');
        Route::get('add', 'ProductController@getAdd');
        Route::put('updateStatus', 'ProductController@updateStatus');
        Route::put('updateHot', 'ProductController@updateHot');
        Route::post('add', 'ProductController@postAdd');
        Route::get('update/{id}', 'ProductController@getUpdate');
        Route::post('update/{id}', 'ProductController@postUpdate');
        Route::get('delete/{id}', 'ProductController@getDelete');
    });*/
    
      
/*});*/


