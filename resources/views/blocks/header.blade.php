<header>
        <div class="container main-nav">
            <div class="row align-items-center ">
                
                <div class="col-lg-2 col-md-2 col-2">
                    <a class="custom-logo" href="<?=env("APP_URL")?>">
                        <img src="/template/image/vnct-logo.png">
                                            </a>
                </div>

                <div class="col-lg col-md-6 col-6 px-lg-3 px-0">
                    <div class="search-box">
                        <form method="get" id="search-form" action="/tim-kiem">
                            <i class="fas fa-search search-icon"></i>
                            
                            <input type="text" id="search-input" name="key" placeholder="<?=df115?>...">
                            
                            <button type="submit" class="search-button">
                                <?=df115?>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-4 d-flex justify-content-end align-items-center header-right" style="gap:10px">
                <div class="search-button">
                    @if(session('business_logged_in'))
                        {{-- Nếu đã đăng nhập thì hiện tên hoặc nút Logout --}}
                        <span>{{ session('business_name') }}!</span>
                        <a href="{{ route('business.logout') }}" class="text-white">{{df125}}</a>
                    @else
                        {{-- Nếu chưa đăng nhập thì hiện nút Login --}}
                        <a href="{{ route('business.login.form') }}" class="text-white">{{df124}}</a>
                    @endif
                </div>
                    
<div class="dropdown d-inline-block">
    <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" id="langDropdown" data-toggle="dropdown">
        @php
            $locales = [
                'vi' => ['flag' => 'vn', 'text' => 'Việt Nam'],
                'fr' => ['flag' => 'fr', 'text' => 'Français'],
                'en' => ['flag' => 'gb', 'text' => 'English'],
                'es' => ['flag' => 'es', 'text' => 'Español']
            ];
            $current = session('languages', 'fr');
        @endphp
        <img src="https://flagcdn.com/w20/{{ $locales[$current]['flag'] ?? $locales['fr']['flag'] }}.png" class="mr-2" style="width:20px;">
        <span>{{ $locales[$current]['text'] ?? $locales['fr']['text'] }}</span>
    </button>
    
    <div class="dropdown-menu lang">
        @foreach($locales as $code => $info)
            <a rel="nofollow" class="dropdown-item d-flex align-items-center btn-switch-lang" 
               href="{{ route('lang.handle', ['locale' => $code]) }}?current_url={{ urlencode(request()->fullUrl()) }}"
               data-lang="{{ $code }}">
                <img src="https://flagcdn.com/w20/{{ $info['flag'] }}.png" class="mr-2"> {{ $info['text'] }}
            </a>
        @endforeach
    </div>
</div>



                    

<!-- Widget Google Translate (ẩn dropdown mặc định) -->
<div id="google_translate_element" style="display:none;"></div>

                   
                </div>
            </div>
        </div>
       
        <div class="container">
           <ul class="sub-nav-menu">
                {{-- <li><a href="<?=env("APP_URL");?>" class="<?=(empty($slug)) ? 'active-link' : '';?>">Accueil</a></li> --}}
              <?php
                $menuheader = json_decode(df26,true);
                if(!empty($menuheader) && count($menuheader) > 0)
                {
                    foreach($menuheader as $v)
                    {
                        $slug_v = FrontEnd::get_link($v);
                        if(!empty($v["children"]) && count($v["children"]) > 0)
                        {
                            $active = "";
                            if(!empty($slug) && $slug==$slug_v) $active = "active-link";
                            echo '<li class="nav-item-dropdown "><a class="dropdown-toggle-ul '.$active.'" href="'.$slug_v.'" >'.$v["name"].' <i class="fas fa-chevron-down" style="font-size: 0.6rem;"></i></a>';
                            echo '<ul class="submenu-ul">';
                            foreach($v["children"] as $sub)
                            {
                                $slug_sub = FrontEnd::get_link($sub);
                                $active = "";
                                if(!empty($slug) && $slug==$slug_sub) $active = "active-link";
                                echo '<li><a class="'.$active.'" href="'.$slug_sub.'">'.$sub["name"].'</a></li>';
                            }
                            echo '</ul>';
                        }
                        else
                        {

                            $active = "";
                            if(!empty($slug) && $slug==$slug_v) $active = "active-link";
                            if($v["link_value"]==69 || $v["link_value"]==68)
                            {
                            	if(session('business_logged_in'))
                            	{
				              		echo '<li ><a  class="'.$active.'" href="'.$slug_v.'" >'.$v["name"].'</a>';
                            	}
				               
                            }
                            else
                            {
                            	echo '<li ><a class="'.$active.'" href="'.$slug_v.'" >'.$v["name"].'</a>';
                        	}
                        }
                        echo '</li>';
                    }
                }
              ?>
                {{--  --}}
            </ul>

        </div>

    </header>
@push('js')
<script type="text/javascript">
 document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('search-form');
    const input = document.getElementById('search-input');

    form.addEventListener('submit', function(event) {
        // 1. Chặn hành động gửi form mặc định
        event.preventDefault();

        // 2. Lấy giá trị tìm kiếm và cắt bỏ khoảng trắng thừa
        let keyword = input.value.trim();

        if (keyword) {
            // Sửa đổi: Chỉ encodeURIComponent để giữ khoảng trắng (thành %20)
            let safeKeyword = encodeURIComponent(keyword);

            // 3. Xây dựng URL theo định dạng mong muốn: /tim-kiem/{key đã encode}
            // Ví dụ: /tim-kiem/Du%20lịch%20Hạ%20Long
            let newUrl = '/tim-kiem/' + safeKeyword;

            // 4. Chuyển hướng người dùng
            window.location.href = newUrl;
        } else {
            // Xử lý khi input trống
            alert('Vui lòng nhập nội dung cần tìm.');
        }
    });
});
</script>
@endpush    