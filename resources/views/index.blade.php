<!DOCTYPE html>
<html>
<head>
  @include("blocks.head")
  @stack('css')

</head>
<body>
@include("blocks.header")
@yield('banner')
<div class="container my-5 content">
  <div class="row">
    <div class="content-left ">
      <div class="content-left-tam "></div>
      <aside class="custom-sidebar d-flex flex-column">
          <ul class="nav flex-column sidebar-nav-list flex-grow-1">
              <?php
                $menuheader = json_decode(df26,true);
                if(!empty($menuheader) && count($menuheader) > 0)
                {
                  foreach($menuheader as $v)
                  {
                    $slug_v = FrontEnd::get_link($v);
                    if($slug_v=="") $slug_v = "home";
                    if(!empty($v["children"]) && count($v["children"]) > 0)
                    {
                        echo '<li class="nav-item has-dropdown active-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="collapse" data-target="#'.$slug_v.'">
                            <i class="fas '.$v["icon"].' sidebar-icon"></i>
                            <span class="sidebar-text">'.$v["name"].'</span>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </a>
                        <div class="collapse" id="'.$slug_v.'">
                            <ul class="nav flex-column sub-menu">';
                            foreach($v["children"] as $sub)
                            {
                              $slug_sub = FrontEnd::get_link($sub);
                              echo ' <li class="nav-item"><a class="nav-link" href="'.$slug_sub.'">'.$sub['name'].'</a></li>';
                            }
                               
                            echo '</ul>
                        </div>';
                    }
                    else
                    {
                      echo '<li class="nav-item">
                        <a class="nav-link " href="'.$slug_v.'">
                            <i class="fas '.$v["icon"].' sidebar-icon"></i>
                            <span class="sidebar-text">'.$v["name"].'</span>
                        </a>';
                    }
                    echo '</li>';
                  }
                }
              ?>
              
              
          </ul>

          <ul class="nav flex-column sidebar-help-list">
              <li class="nav-item">
                  <a class="nav-link" href="<?=df112?>">
                      <i class="fas fa-question-circle sidebar-icon"></i>
                      <span class="sidebar-text"><?=df111?></span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="<?=df114?>">
                      <i class="fas fa-pencil-alt sidebar-icon"></i>
                      <span class="sidebar-text"><?=df113?></span>
                  </a>
              </li>
          </ul>
         
    </aside>
    </div>
    
    
    <div class="col-12 col-lg-11">
      @yield('content')
    </div>
</div>
</div>

@include("blocks.footer")
@stack('js')
<script type="text/javascript">
function isTabletView() {
  return window.innerWidth <= 1024;
}
 var $sidebar = $('.custom-sidebar');

    // Kiểm tra xem phần tử có tồn tại không
    if ($sidebar.length) {
        // 2. Tính toán vị trí Y của Sidebar so với đầu trang
        // .offset().top lấy vị trí tuyệt đối của phần tử so với tài liệu.
        var sidebarOffsetTop = $sidebar.offset().top;

        // Biến cờ (flag) để đảm bảo alert chỉ hiện một lần
        var alertShown = false;

        // 3. Xử lý sự kiện cuộn (scroll)
        $(window).scroll(function() {
            // Lấy vị trí cuộn hiện tại của cửa sổ trình duyệt
            var scrollPosition = $(window).scrollTop();
            console.log(scrollPosition + " - " +sidebarOffsetTop)
            // Điều kiện kích hoạt:
            // Nếu vị trí cuộn lớn hơn hoặc bằng vị trí của sidebar VÀ alert chưa được hiển thị
            if (scrollPosition >= sidebarOffsetTop && !alertShown) {
                
                // Hiển thị thông báo ALERT
                //alert("Bạn đã cuộn xuống và chạm vào vị trí của Sidebar (.custom-sidebar)!");
                
                // Đặt cờ thành true để ngăn alert hiển thị lại
                alertShown = true;

                $sidebar.css({
                  'position': 'fixed',
                  'top':'0',
                  'left': '0',
                  
                });
                
                // --- TUỲ CHỌN: Nếu bạn muốn ALERT hiện lại khi cuộn lên trên ---
                // Bạn có thể bỏ qua bước này nếu chỉ muốn alert hiện 1 lần.
                /*
                setTimeout(function() {
                    alertShown = false; // Thiết lập lại cờ sau 5 giây (hoặc thời gian khác)
                    console.log("Cờ alert đã được reset.");
                }, 5000); 
                */
                // -----------------------------------------------------------------
            } 
            // Nếu vị trí cuộn lùi lên trên và alert đã hiện, thiết lập lại cờ (tùy chọn)
            else if (scrollPosition < sidebarOffsetTop && alertShown) {
                 // Nếu bạn muốn alert hiện lại mỗi lần cuộn xuống:
                 alertShown = false;
                 $sidebar.attr('style','');
            }
        });
    } 

document.querySelectorAll('.sub-nav-menu > li').forEach(li => {
  li.addEventListener('click', e => {
    $('.sub-nav-menu > li').removeClass("hover");
    $(li).addClass("hover");
    if (!isTabletView()) return;

    let submenu = li.querySelector('.submenu-ul') || document.querySelector(`.submenu-ul[data-parent='${li.dataset.id}']`);
    if (!submenu) return;

    e.preventDefault();
    e.stopPropagation();

    const isOpen = submenu.style.display === 'block';

    // Ẩn tất cả submenu khác và đưa chúng về lại li gốc
    document.querySelectorAll('.submenu-ul').forEach(sm => {
      if (sm.dataset.parent) {
        const parentLi = document.querySelector(`.sub-nav-menu > li[data-id='${sm.dataset.parent}']`);
        if (parentLi && !parentLi.contains(sm)) parentLi.appendChild(sm);
      }
      sm.style.display = 'none';
    });

    if (isOpen) {
      // Khi tắt thì gắn lại vào li gốc
      li.appendChild(submenu);
      submenu.style.display = 'none';
      return;
    }

    // Đánh dấu id của li để còn gắn lại đúng
    if (!li.dataset.id) li.dataset.id = Math.random().toString(36).substring(2, 9);
    submenu.dataset.parent = li.dataset.id;

    // Đưa submenu ra ngoài body
    document.body.appendChild(submenu);
    if(window.innerWidth >= 768 && window.innerWidth <= 1024)
    {
      const rect = li.getBoundingClientRect();
      submenu.style.position = 'absolute';
      submenu.style.top = (rect.bottom + 25) + window.scrollY + 'px';
      submenu.style.left = rect.left + window.scrollX + 'px';
      submenu.style.display = 'block';
      submenu.style.zIndex = 9999;
      submenu.style.background = '#fff';
      submenu.style.boxShadow = '0 3px 8px rgba(0,0,0,0.2)';
      submenu.style.opacity = 1; 
      submenu.style.visibility = 'visible';
      submenu.style.minWidth = '220px';
    }
    if(window.innerWidth <= 768)
    {
      const rect = li.getBoundingClientRect();
      submenu.style.position = 'absolute';
      submenu.style.top = (rect.bottom) + window.scrollY + 'px';
      submenu.style.left = 0;
      submenu.style.display = 'block';
      submenu.style.zIndex = 9999;
      submenu.style.background = '#fff';
      submenu.style.boxShadow = '0 3px 8px rgba(0,0,0,0.2)';
      submenu.style.opacity = 1; 
      submenu.style.visibility = 'visible';
      submenu.style.minWidth = '100%';
    }
  });
});

// Ẩn submenu khi click ra ngoài
document.addEventListener('click', e => {
  if (!isTabletView()) return;
  if (!e.target.closest('.sub-nav-menu') && !e.target.closest('.submenu-ul')) {
    document.querySelectorAll('.submenu-ul').forEach(sm => {
      if (sm.dataset.parent) {
        const parentLi = document.querySelector(`.sub-nav-menu > li[data-id='${sm.dataset.parent}']`);
        if (parentLi && !parentLi.contains(sm)) parentLi.appendChild(sm);
      }
      sm.style.display = 'none';
    });
  }
});
$(function() {
    // Bước 1: gắn active-link cho cấp cha nếu cấp con có
    $('.submenu-ul').each(function() {
        if ($(this).find('a.active-link').length > 0) {
            $(this).prev('a.dropdown-toggle-ul').addClass('active-link');
        }
    });

    // Bước 2: sau khi DOM update, scroll tới thẻ active cấp cha
     requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            const $menu = $('.sub-nav-menu');
            const $active = $menu.find('> li > a.active-link');
            if ($active.length) {
                // Dùng scrollIntoView: auto chọn container đúng
                $active[0].scrollIntoView({
                    behavior: 'smooth',
                    inline: 'center',
                    block: 'nearest'
                });
            }
        });
    });
});

// $(function() {
//     $('.submenu-ul').each(function() {
//         if ($(this).find('a.active-link').length > 0) {
//             $(this).prev('a.dropdown-toggle-ul').addClass('active-link');
//             console.log("vào 1");
//         }
        
//     }).promise().done(function() {
//         console.log("vào 2");
//         const $menu = $('.sub-nav-menu');
//         const $active = $menu.find('> li > a.active-link');
        
//         if ($active.length) {
//             const scrollLeft = $active.position().left - $menu.width() / 2 + $active.outerWidth() / 2;
//             $menu.animate({ scrollLeft: scrollLeft }, 100);
//         }
//     });

// });



</script>
<!-- Script Google Translate -->
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: '<?php echo session('languagess', 'fr'); ?>',
    layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
    autoDisplay: false
  }, 'google_translate_element');
}
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<!-- Script xử lý chọn ngôn ngữ -->
<script>
function setCookie(name, value, days, domain = '') {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    
    let cookieString = name + "=" + encodeURIComponent(value || "") + expires + "; path=/";
    
    if (domain) {
        cookieString += "; domain=" + domain;
    }
    
    document.cookie = cookieString;
}

function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) {
            return decodeURIComponent(c.substring(nameEQ.length, c.length));
        }
    }
    return null;
}

function applyTranslate(lang) {
    // 1. Cập nhật cookie Google Translate
    const pair = '/<?php echo session('languages', 'fr'); ?>/' + lang;
    const domain = location.hostname.replace(/^www\./, '');
    
    // Đặt cookie cho subdomain hiện tại
    setCookie('googtrans', pair, 365);
    
    // Đặt cookie cho domain chính (có dấu chấm đầu)
    if (domain !== 'localhost' && !domain.match(/^\d+\.\d+\.\d+\.\d+$/)) {
        setCookie('googtrans', pair, 365, '.' + domain);
    }
    
    // 2. Gửi request để cập nhật session ngôn ngữ
    fetch('/update-language-session', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify({ language: lang })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 3. Reload trang sau khi đã cập nhật session
            setTimeout(() => {
                window.location.reload();
            }, 100);
        } else {
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Error updating language session:', error);
        window.location.reload();
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const items = document.querySelectorAll('.btn-switch-lang[data-lang]');
    
    items.forEach(item => {
        item.addEventListener('click', e => {
            e.preventDefault();
            const lang = item.getAttribute('data-lang');
            
            if (lang === 'en' || lang === 'es') {
                // Dùng Google Translate cho tiếng Anh và Tây Ban Nha
                applyTranslate(lang); 
            } else {
                // Xóa cookie Google Translate trước
                const domain = location.hostname.replace(/^www\./, '');
                setCookie('googtrans', '', -1);
                
                if (domain !== 'localhost' && !domain.match(/^\d+\.\d+\.\d+\.\d+$/)) {
                    setCookie('googtrans', '', -1, '.' + domain);
                }
                
                // Chuyển hướng đến route xử lý ngôn ngữ
                const currentUrl = item.getAttribute('href');
                window.location.href = currentUrl;
            }
        });
    });
});
</script>

</body>
</html>



