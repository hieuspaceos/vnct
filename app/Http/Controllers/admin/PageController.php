<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Terms;
use App\Models\Posts;
use App\Models\Config;
use App\Http\Requests\admin\login;
use App\Http\Lib\Terms_lib;
use App\Http\Lib\Product_lib;
use App\Http\Requests\admin\danhmuc_add;
use App\Http\Requests\admin\product;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Models\language;
class PageController extends Controller
{
	protected $terms;
	protected $libproduct;
	public function __construct(Terms_lib $terms,Product_lib $libproduct)
	{
		$this->terms = $terms;
		$this->libproduct = $libproduct;  
	}
   
	public function index()
	{       
        //dd(Session::all());
		return view('admin.page.home',['title'=>"Trang quản trị"]);
	}
    public function login()
    {
    	return view('admin.page.login',['title'=>'Đăng nhập','login'=>1]);
    }
    public function checklogin(login $request) // login kiếm tra validate
    {
        // dd("ok");
    	/*$this->validate($request,[
    		'email'=> 'required|email:filter',
    		'password'=>'required'
    	]);*/
    	// kiểm tra email với pass đúng với database hay không
        
    	if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')],$request->input('remember')))
    	{
            //dd($request->input());
    		if(Auth::user()->Level==0)
            {
                Auth::logout();
                Session::flash('login_failed','Email hoặc mật khẩu không đúng');
                return redirect()->route('login_admin');
            }

    		return redirect()->route('main_admin');
    	}
    	else
    	{
    		// set session lỗi - tạo mới session 
    		Session::flash('login_failed','Email hoặc mật khẩu không đúng');
    		return redirect()->back();
    	}
    }
     /*===========
    	Danh mục
    =============*/
    public function danhmuc_list()
    { 
        // dd(Session::all());
        //dd(Session::get('language'));   	
    	  $allMenus = Terms::orderBy('id', 'desc')->paginate(10); 

         //dd($allMenus);   
    	return view('admin/page/danhmuc_list',['title'=>"Danh sách danh mục",'allmenu'=>$allMenus]);
    }
    public function danhmuc_add()
    {
    	//$allMenus = terms::pluck('Name','id')->all();    	
    	$cates = Terms::where("Parent",0)->get();  
          $allMenus = Terms::all();   	
    	return view('admin/page/danhmuc_add',['title'=>"Thêm danh mục","cates"=>$cates,'allMenus'=> $allMenus]);//
    }
    public function danhmuc_add_store(danhmuc_add $request)
    {
    	$this->terms->insert($request);
    	return redirect()->back();
    }
    public function danhmuc_edit(Terms $id)
    {
        //$id = Terms::find($id);
        if($id->lang != App::getLocale())
        {
            $lang = language::find($id->lang);
            $redirectUrl = url("admin/danhmuc/edit/{$id->id}");

            return redirect()->route("admin.changelanguages", [
                "lang" => $lang->Name,
                "redirect" => $redirectUrl
            ]);
            //return redirect()->route("admin.changelanguages",["lang"=>$lang->Name]);
        }
        
         $allMenus = Terms::all(); 

    	return view('admin/page/danhmuc_edit',['title'=>"Sửa danh mục ".$id->Name,'cate'=>$id,'allMenus'=>$allMenus]);
    }
    public function danhmuc_copy_lang($lang, Terms $id)
    {
        //$id = Terms::find($id);
        
        $allMenus = Terms::withoutGlobalScopes()
                    ->where('lang', $lang)
                    ->get();

        return view('admin/page/danhmuc_copy_lang',['title'=>"Sửa danh mục ".$id->Name,'cate'=>$id,'allMenus'=>$allMenus,"lang"=>$lang]);
    }
    public function danhmuc_edit_store(danhmuc_add $request,Terms $id)
    {
    	$this->terms->update($request,$id);
    	return redirect()->route('danhmuc_list');
    }
    public function danhmuc_delete($id)
    {
        if(Auth::user()->Level==1)
        {
            $term = Terms::withoutGlobalScopes()->find($id);
            
            if($term) {
                $originId = $term->origin_id ?? $term->id;
                
                // Lấy tất cả terms liên quan
                $termIds = Terms::withoutGlobalScopes()
                    ->where(function($query) use ($originId) {
                        $query->where('id', $originId)
                              ->orWhere('origin_id', $originId);
                    })
                    ->pluck('id')
                    ->toArray();
                
                // Xóa các liên kết trong bảng terms_posts
                DB::table('terms_posts')
                    ->whereIn('terms_id', $termIds)
                    ->delete();
                
                // Sau đó xóa terms
                Terms::withoutGlobalScopes()
                    ->whereIn('id', $termIds)
                    ->delete();
            }
        }
    	return redirect()->back();    	
    }

    /*===========
    	product
    =============*/
    public function product_list()
    { 
    //dd(getimagesize($_SERVER["DOCUMENT_ROOT"] ."/uploads/album/400-400-e7fa8db64c1328a3b8b47e6403af317f.jpg")) ;  	
    	 $allPosts = Posts::with('Terms')->with('color')->where("Post_Type","sanpham")->orderBy("id","desc")->get()->toArray();  
//dd($allPosts);
    	return view('admin/page/product_list',['title'=>"Danh sách sản phẩm",'allPosts'=>$allPosts]);
    }
    public function product_add()
    {
         // dd($request->input()); 
    	//$allMenus = terms::pluck('Name','id')->all();    	    	
    	 $allMenus = Terms::where("Taxonomy","sanpham")->where('AnHien',1)->get();    	
    	return view('admin/page/product_add',['title'=>"Thêm sản phẩm","allMenus"=>$allMenus]);//
    }
    public function product_add_store(Request $request)
    {
    //dd($request->input());    	    
    	$this->libproduct->insert($request);	    
    	return redirect()->route('sanpham');
    }
    public function product_edit(Posts $id)
    {
        //dd($id);
        $idpost = $id->id;       
        $id = $id::with('Color')->with('Terms')->where("id",$id->id)->get(); 
        //dd($id->toArray());           
    	$allMenus = Terms::where("Taxonomy","sanpham")->get();
    	$array_cate_select=array();
    	foreach ($id[0]->terms as $value) {
    		array_push($array_cate_select, $value->id);
    	}
         $list_color = Color::where("id","<>",1)->get(); 
         $list_size = Size::where("id","<>",1)->get();    	
    	return view('admin/page/product_edit',['title'=>"Sửa sản phẩm: ".$id[0]->Post_Title,
    		'Post'=>$id,
    		"allMenus"=>$allMenus,
    		"cateselect"=>$array_cate_select,
            "list_color"=> $list_color,
            "list_size"=>$list_size
    	]);
    }
    public function product_edit_store(Request $request,Posts $id)
    {
    	//dd("ok");
    	$this->libproduct->update($request,$id);
    	return redirect()->route('sanpham');
    }
    public function product_copy(Posts $id)
    {
        $idpost = $id->id;       
        $id = $id::with('Color')->with('Terms')->where("id",$id->id)->get(); 
        //dd($id->toArray());           
        $allMenus = Terms::where("Taxonomy","sanpham")->get();
        $array_cate_select=array();
        foreach ($id[0]->terms as $value) {
            array_push($array_cate_select, $value->id);
        }
         $list_color = Color::where("id","<>",1)->get(); 
         $list_size = Size::where("id","<>",1)->get();      
        return view('admin/page/product_copy',['title'=>"Copy phẩm: ".$id[0]->Post_Title,
            'Post'=>$id,
            "allMenus"=>$allMenus,
            "cateselect"=>$array_cate_select,
            "list_color"=> $list_color,
            "list_size"=>$list_size
        ]);
    }
    public function product_delete($id)
    {       
    	//Posts::destroy($id);

        Posts::find($id)->Terms()->detach();
        Posts::find($id)->Color()->detach();
        Posts::destroy($id);
    	return redirect()->back();    	
    }

    /*===========
        color
    =============*/

     public function product_list_color()
    {       
        $list_color = Color::all();       
       return view('admin.page.product_list_color',[
            "title" => "danh sách",
            "list"=>$list_color
       ]) ;
    }
    public function product_add_color()
    {                   
       return view('admin.page.product_add_color',[
            "title" => "danh sách"
            
       ]) ;
    }
    public function product_add_store_color(Request $request)
    {
        if(Color::Where("Name",$request->input('Name'))->where("Ma_Mau",$request->input('Ma_Mau'))->exists())
        {
             Session::flash('error', "Màu đã tồn tại");
            
        }
        else
        {
            Color::Create(["Name"=>$request->input('Name'),"Ma_Mau" => $request->input('Ma_Mau')]);
            Session::flash('success', "Thêm thành công");
        }
       return redirect()->back();
    }
    public function product_edit_color(Color $id)
    {                   
       return view('admin.page.product_edit_color',[
            "title" => "danh sách",
            "Color" => $id
       ]) ;
    }
    public function product_edit_store_color(Request $request,Color $id)
    {                          
        $id->Name = (string) $request->input('Name');
        $id->Ma_Mau = (string) $request->input('Ma_Mau');
        $id->save();
        Session::flash('success', "Sữa thành công");
       return redirect()->back();
    }
    public function get_list_color()
    {
        $list = Color::all();
       $str = '';
       $str.='<option value="1">Chọn Color</option>';
        foreach ($list as $key => $value) {
            $str.="<option value='".$value->id."' >".$value->Name."</option>";
        }
        return $str;

    }
    public function insert_color(Request $request)
    {
        if(Color::Where("Name",$request->input('Name'))->exists())
        {
            return array("success"=>false);
            
        }
        else
        {
            Color::Create(["Name"=>$request->input('Name'),"Ma_Mau"=>""]);
            return array("success"=>true);
        }      
    }
    /*===========
        size
    =============*/

     public function product_list_size()
    {       
        $list_color = Size::all();       
       return view('admin.page.product_list_size',[
            "title" => "danh sách",
            "list"=>$list_color
       ]) ;
    }
    public function product_add_size()
    {                   
       return view('admin.page.product_add_size',[
            "title" => "danh sách"
            
       ]) ;
    }
    public function product_add_store_size(Request $request)
    {

        if(Size::Where("Name",$request->input('Name'))->exists())
        {
             Session::flash('error', "Màu đã tồn tại");
            
        }
        else
        {
            Size::Create(["Name"=>$request->input('Name')]);
            Session::flash('success', "Thêm thành công");
        }
       return redirect()->back();
    }
    public function product_edit_size(Size $id)
    {                   
       return view('admin.page.product_edit_size',[
            "title" => "danh sách",
            "Color" => $id
       ]) ;
    }
    public function product_edit_store_size(Request $request,Size $id)
    {                          
        $id->Name = (string) $request->input('Name');      
        $id->save();
        Session::flash('success', "Sữa thành công");
       return redirect()->back();
    }
    public function get_list_size()
    {
        $list = Size::all();
       $str = '';
       $str.='<option value="1">Chọn Size</option>';
        foreach ($list as $key => $value) {
            $str.="<option value='".$value->id."' >".$value->Name."</option>";
        }
        return $str;

    }
    public function insert_size(Request $request)
    {
        if(Size::Where("Name",$request->input('Name'))->exists())
        {
            return array("success"=>false);
            
        }
        else
        {
            Size::Create(["Name"=>$request->input('Name')]);
            return array("success"=>true);
        }      
    }
    /*===========
        Bài viết
    =============*/
    public function baiviet_list(Request $request)
{       
    $query = Posts::with('Terms')->where("Post_Type","tintuc");
    
    // Xử lý tìm kiếm
    if($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('Post_Title', 'like', '%'.$search.'%')
              ->orWhere('id', 'like', '%'.$search.'%');
        });
    }
    
    $allPosts = $query->orderBy('id', 'desc')->paginate(10);
    
    // Giữ lại từ khóa tìm kiếm khi phân trang
    $allPosts->appends(['search' => $request->search]);
    
    return view('admin/page/baiviet_list',[
        'title'=>"Danh sách tin tức",
        'allPosts'=>$allPosts,
        'searchKeyword' => $request->search
    ]);
}
    public function baiviet_add()
    {
        //$allMenus = terms::pluck('Name','id')->all();             
         $allMenus = Terms::where("Taxonomy","tintuc")->where('AnHien',1)->get();     
        return view('admin/page/baiviet_add',['title'=>"Thêm tin tức","allMenus"=>$allMenus]);//
    }
    public function baiviet_add_store(product $request)
    {           
        $this->libproduct->insert($request);        
        return redirect()->back();
    }
    public function baiviet_edit(Posts $id)
    {
        //dd($id->lang);
        if($id->lang != App::getLocale())
        {
            $lang = language::find($id->lang);
            $redirectUrl = url("admin/baiviet/edit/{$id->id}");
            return redirect()->route("admin.changelanguages", [
                "lang" => $lang->Name,
                "redirect" => $redirectUrl
            ]);
            //return redirect()->route("admin.changelanguages",["lang"=>$lang->Name]);
        }
        $id = $id::with('Terms')->where("id",$id->id)->get();  
        
        $allMenus = Terms::withoutGlobalScopes()->where("lang",$id[0]->lang)->where("Taxonomy","tintuc")->get();
        $array_cate_select=array();
        foreach ($id[0]->terms as $value) {
            array_push($array_cate_select, $value->id);
        }       
        return view('admin/page/baiviet_edit',['title'=>"Sửa tin tức: ".$id[0]->Post_Title,
            'Post'=>$id,
            "allMenus"=>$allMenus,
            "cateselect"=>$array_cate_select,
        ]);
    }
    public function baiviet_copy(Posts $id)
    {
        
        $id = $id::with('Terms')->where("id",$id->id)->get();          
        $allMenus = Terms::where("Taxonomy","tintuc")->get();
        $array_cate_select=array();
        foreach ($id[0]->terms as $value) {
            array_push($array_cate_select, $value->id);
        }       
        return view('admin/page/baiviet_copy',['title'=>"copy tin tức: ".$id[0]->Post_Title,
            'Post'=>$id,
            "allMenus"=>$allMenus,
            "cateselect"=>$array_cate_select,
        ]);
    }
    public function baiviet_copy_lang($lang, Posts $id)
    {
        
                 
        $allMenus = Terms::withoutGlobalScopes()
                    ->where('lang', $lang)->where("Taxonomy","tintuc")->get();
        $array_cate_select=array();            
        return view('admin/page/baiviet_copy_lang',['title'=>"Thêm bản dịch : ".$id->Post_Title,
            'Post'=>$id,
            "allMenus"=>$allMenus,
            "lang" => $lang,
            "cateselect"=>$array_cate_select,
        ]);
    }
    public function baiviet_edit_store(product $request,Posts $id)
    {
        //dd($request->input());
        //dd($id);
        $this->libproduct->update($request,$id);
        return redirect()->back();
    }
    public function baiviet_delete($id)
    {       
        if(Auth::user()->Level==1)
        {
            // Lấy bài viết cần xóa
            $post = Posts::withoutGlobalScopes()->find($id);
            
            if($post) {
                // Xác định origin_id (nếu là bản dịch thì lấy origin_id, nếu là bản gốc thì lấy id)
                $originId = $post->origin_id ?? $post->id;
                
                // Lấy tất cả bài viết liên quan (bản gốc + các bản dịch)
                $postIds = Posts::withoutGlobalScopes()
                    ->where(function($query) use ($originId) {
                        $query->where('id', $originId)
                              ->orWhere('origin_id', $originId);
                    })
                    ->pluck('id')
                    ->toArray();
                
                // Xóa tất cả liên kết terms_posts của các bài viết này
                DB::table('terms_posts')
                    ->whereIn('posts_id', $postIds)
                    ->delete();
                
                // Xóa tất cả bài viết (bản gốc + các bản dịch)
                Posts::withoutGlobalScopes()
                    ->whereIn('id', $postIds)
                    ->delete();
            }
        }
        return redirect()->back();      
    }
    /*===========
        config
    =============*/
    public function config_list()
    {
        if(Auth::user()->Level!=1)
        {
            return false;
        }
        $allMenus = Terms::where('Name','<>','rong')->get()->toArray();
        $allMenus_notpage = Terms::where('AnHien',1)->get()->toArray();
       
        $config = Config::where("page","")->orderBy('thutu')->get();
        $home = Config::where("page","home")->orderBy('thutu')->get()->toArray();       
      
        $menu = Config::where("page","menu")->get()->toArray();
        $popup = Config::where("page","popup")->get()->toArray();
        $textareaIds =  Config::where('Type', 'textarea')->pluck('id')->implode(',');
        $checkboxCateIds = Config::where('Type', 'checkbox_cate')->pluck('id')->implode(',');
        //dd($textareaIds);
        return view("admin.page.config_list",["title"=>"Sửa config",
            "config"=>$config,
            "home"=>$home,
            "allMenus_notpage"=>$allMenus_notpage,
            "allMenus" =>$allMenus,
            "menu"=>$menu,
            "textareaIds" => $textareaIds,
            "checkboxCateIds" => $checkboxCateIds,
             "popup"=>$popup
        ]);
    }
    public function config_edit(Request $request)
    {
        if(Auth::user()->Level!=1)
        {
            return false;
        }
        try {
            //dd($request);
            if(!empty($request->save_presentation))
            {
               
               
               // Lọc ra chỉ các field bắt đầu bằng "intro_"
                $allData = $request->all();
                $introData = [];
                
                foreach ($allData as $key => $value) {
                    if (strpos($key, 'presentation_') === 0) {
                        // Loại bỏ prefix "intro_" để lưu vào JSON
                        $jsonKey = substr($key, 13); // bỏ 6 ký tự "intro_"
                        $introData[$jsonKey] = $value;
                    }
                }
                
                $json_file = public_path('template/files/presentation_'.App::currentLocale().'.json');
                $json_data = json_encode($introData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                
                try {
                    File::put($json_file, $json_data);
                    return redirect()->back()->with('success', 'Cập nhật presentation thành công!');
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
                }

            }
            if(!empty($request->save_introduccion))
            {
                // Lọc ra chỉ các field bắt đầu bằng "intro_"
                $allData = $request->all();
                $introData = [];
                
                foreach ($allData as $key => $value) {
                    if (strpos($key, 'intro_') === 0) {
                        // Loại bỏ prefix "intro_" để lưu vào JSON
                        $jsonKey = substr($key, 6); // bỏ 6 ký tự "intro_"
                        $introData[$jsonKey] = $value;
                    }
                }
                
                $json_file = public_path('template/files/introduccion_'.App::currentLocale().'.json');
                $json_data = json_encode($introData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                
                try {
                    File::put($json_file, $json_data);
                    return redirect()->back()->with('success', 'Cập nhật introduccion thành công!');
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
                }
            }

            if (!empty($request->save_contact)) {
                // Lọc ra chỉ các field bắt đầu bằng "contact_"
                $allData = $request->all();
                $contactData = [];
                
                foreach ($allData as $key => $value) {
                    if (strpos($key, 'contact_') === 0) {
                        // Loại bỏ prefix "contact_" để lưu vào JSON
                        $jsonKey = substr($key, 8); // bỏ 8 ký tự "contact_"
                        $contactData[$jsonKey] = $value;
                    }
                }
                
                $json_file = public_path('template/files/contact_'.App::currentLocale().'.json');
                $json_data = json_encode($contactData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                
                try {
                    File::put($json_file, $json_data);
                    return redirect()->back()->with('success', 'Cập nhật trang Contact thành công!');
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
                }
            }

            if (!empty($request->save_member)) {
                // Lọc ra chỉ các field bắt đầu bằng "member_"
                $allData = $request->all();
                $memberData = [];
                
                foreach ($allData as $key => $value) {
                    if (strpos($key, 'membres_') === 0) {
                        // Loại bỏ prefix "member_" để lưu vào JSON
                        $jsonKey = substr($key, 8); // bỏ 8 ký tự "member_"
                        $memberData[$jsonKey] = $value;
                    }
                }
                //dd($memberData);
                $json_file = public_path('template/files/membres_'.App::currentLocale().'.json');
                $json_data = json_encode($memberData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                
                try {
                    File::put($json_file, $json_data);
                    return redirect()->back()->with('success', 'Cập nhật trang member thành công!');
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
                }
            }
            if (!empty($request->save_login)) {
                // Lọc ra chỉ các field bắt đầu bằng "member_"
                $allData = $request->all();
                $memberData = [];
                
                foreach ($allData as $key => $value) {
                    if (strpos($key, 'auth_') === 0) {
                        // Loại bỏ prefix "member_" để lưu vào JSON
                        $jsonKey = substr($key, 5); // bỏ 8 ký tự "member_"
                        $memberData[$jsonKey] = $value;
                    }
                }
                //dd($memberData);
                $json_file = public_path('template/files/auth_'.App::currentLocale().'.json');
                $json_data = json_encode($memberData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                
                try {
                    File::put($json_file, $json_data);
                    return redirect()->back()->with('success', 'Cập nhật trang auth thành công!');
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
                }
            }

            DB::beginTransaction();
            
            // Lấy tất cả data từ request
            $data = $request->except(['_token', 'btn_save', 'textarea_array', 'checkbox_cate_array']);
            
            //dd($data);
            foreach ($data as $key => $value) {
                // Xử lý slide (nhiều giá trị thành JSON)
                if (strpos($key, 'slide') === 0) {
                    $slideData = $request->input($key);
                    if (is_array($slideData)) {
                        $value = json_encode($slideData, JSON_UNESCAPED_UNICODE);
                    }
                    $configId = str_replace('slide', '', $key);
                    $key = $configId;
                }
                
                // Xử lý checkbox_cate (nhiều checkbox thành chuỗi phân cách bằng dấu phẩy)
                if (strpos($key, 'arraycheckbox') === 0) {
                    $configId = str_replace('arraycheckbox', '', $key);
                    $checkboxValues = $request->input($key, []);
                    $value = implode(',', $checkboxValues);
                    $key = $configId;
                }
                
                // Xử lý menu (giữ nguyên JSON)
                if (strpos($key, 'menu') === 0) {
                    
                    // Value đã là JSON string rồi
                    $value = $value;
                    $configId = str_replace('menu', '', $key);
                    $key = $configId;
                }
                
                // Xử lý image field
                if (strpos($key, 'imagehinh') === 0) {
                    $configId = str_replace('imagehinh', '', $key);
                    $key = $configId;
                }
                
                // Update vào database
                DB::table('configs')
                    ->where('id', $key)
                    ->update([
                        'Value' => $value,
                        'updated_at' => now()
                    ]);
            }
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Cập nhật config thành công!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
       //dd($request->input());
       //Terms::query()->update(['Parent' => 0,'ThuTu'=>0,'vitri'=>0]);
        
        // foreach ($request->input() as $key => $value) {
        //     if($key!="btn_save" && $key!="_token")
        //     {
        //     $pos = strpos($key,"imagehinh");
        //     if($pos===false){}
        //     else
        //     {$key = str_replace("imagehinh", "", $key);  }
        //     $pos = strpos($key,"menu");
        //     if($pos===false){}
        //     else
        //     {
        //         $array = json_decode($value, true); 
        //        $dem1 = 0;
        //        /* if(count($array)>0)
        //         {
                   
        //            foreach ($array as $v) {
        //              $dem1++;
        //               // $this->update_taxomony($v["id"],0,$dem1);
        //                $up_term = Terms::find($v["id"]);
        //                $up_term->Parent = 0;
        //                $up_term->ThuTu = $dem1;
        //                 $up_term->vitri = 1;
        //                $up_term->save();
        //                if(isset($v["children"]) and count($v["children"]) > 0)
        //                {
        //                     $dem2 = 0;
        //                     foreach ($v["children"] as $v1) {
        //                          $dem2++;
        //                         //$this->update_taxomony($v1["id"],$v["id"],$dem2);
        //                          $up_term = Terms::find($v1["id"]);
        //                            $up_term->Parent = $v["id"];
        //                            $up_term->ThuTu = $dem2;
        //                            $up_term->vitri = 1;
        //                            $up_term->save();
        //                              $dem3 = 0;
        //                             if(isset($v1["children"]) and count($v1["children"]) > 0 )
        //                                {
        //                                     foreach ($v1["children"] as $v2) {
        //                                          $dem3++;
        //                                        // $this->update_taxomony($v2["id"],$v1["id"],$dem3);
        //                                         $up_term = Terms::find($v2["id"]);
        //                                            $up_term->Parent = $v1["id"];
        //                                            $up_term->ThuTu = $dem3;
        //                                             $up_term->vitri = 1;
        //                                            $up_term->save();
        //                                     }
        //                                }
        //                     }
        //                }
        //             } 
        //         }*/
        //      $key = str_replace("menu", "", $key);  
        //     }
        //      $pos = strpos($key,"arraycheckbox");
        //     if($pos===false){}
        //     else
        //     {
        //         if(count($value)>0)
        //         {
        //             $value = implode(",",$value);                    
        //         }
        //         $key = str_replace("arraycheckbox", "", $key);  
        //     }
        //      $pos = strpos($key,"slide");
        //     if($pos===false){}
        //     else
        //     {
        //         $value = json_encode($value, JSON_UNESCAPED_UNICODE);
        //         $key = str_replace("slide", "", $key);  
        //     }
        //       if($value==null)
        //       {
        //         $value = "";
        //       }
        //        $up = Config::find($key);
        //        $up->Value = $value;
        //        $up->save();
        //     }
             
        // }
        // return redirect()->back();
    }
}
