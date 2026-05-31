@include('admin.blocks.header')

<?php $url = explode("/", url()->full());

  $page = (isset($url[4]))?$url[4]:0;

 ?>

<div class="wrapper">

  <!-- Navbar -->

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Left navbar links -->

    <ul class="navbar-nav">

      <li class="nav-item">

        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>

      </li>

      

    </ul>



    <!-- Right navbar links -->

    <ul class="navbar-nav ml-auto">

      <!-- Navbar Search -->

     



      <!-- Messages Dropdown Menu -->

     {{--  <li class="nav-item dropdown">

        <a class="nav-link" data-toggle="dropdown" href="#">

          <i class="far fa-comments"></i>

          <span class="badge badge-danger navbar-badge">3</span>

        </a>

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

          <a href="#" class="dropdown-item">

            <!-- Message Start -->

            <div class="media">

              <img src="/template/admin/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">

              <div class="media-body">

                <h3 class="dropdown-item-title">

                  Brad Diesel

                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>

                </h3>

                <p class="text-sm">Call me whenever you can...</p>

                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>

              </div>

            </div>

            <!-- Message End -->

          </a>

          <div class="dropdown-divider"></div>

          <a href="#" class="dropdown-item">

            <!-- Message Start -->

            <div class="media">

              <img src="/template/admin/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">

              <div class="media-body">

                <h3 class="dropdown-item-title">

                  John Pierce

                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>

                </h3>

                <p class="text-sm">I got your message bro</p>

                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>

              </div>

            </div>

            <!-- Message End -->

          </a>

          <div class="dropdown-divider"></div>

          <a href="#" class="dropdown-item">

            <!-- Message Start -->

            <div class="media">

              <img src="/template/admin/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">

              <div class="media-body">

                <h3 class="dropdown-item-title">

                  Nora Silvester

                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>

                </h3>

                <p class="text-sm">The subject goes here</p>

                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>

              </div>

            </div>

            <!-- Message End -->

          </a>

          <div class="dropdown-divider"></div>

          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>

        </div>

      </li> --}}

      <!-- Notifications Dropdown Menu -->

       <li class="nav-item dropdown">
          <div class="dropdown d-inline-block">
    <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" id="langDropdown" data-toggle="dropdown">
        @php
            $locales = [
                'vi' => ['flag' => 'vn', 'text' => 'Việt Nam'],
                'fr' => ['flag' => 'fr', 'text' => 'Français']
            ];
            $current = (\App::getLocale() == 2) ? 'vi' : 'fr';
        @endphp
        <img src="https://flagcdn.com/w20/{{ $locales[$current]['flag'] ?? $locales['fr']['flag'] }}.png" class="mr-2" style="width:20px;">
        <span>{{ $locales[$current]['text'] ?? $locales['fr']['text'] }}</span>
    </button>
    
    <div class="dropdown-menu lang">
        @foreach($locales as $code => $info)
            <a rel="nofollow" class="dropdown-item d-flex align-items-center btn-switch-lang" 
               href="{{ route('admin.changelanguages', ['lang' => $code]) }}"
               data-lang="{{ $code }}">
                <img src="https://flagcdn.com/w20/{{ $info['flag'] }}.png" class="mr-2"> {{ $info['text'] }}
            </a>
        @endforeach
    </div>
</div>
        
      </li> 

     

    </ul>

  </nav>

  <!-- /.navbar -->



  <!-- Main Sidebar Container -->

  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->

    <a href="/template/admin/index3.html" class="brand-link">

      <img src="/template/admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">

      <span class="brand-text font-weight-light">Admin</span>

    </a>



    <!-- Sidebar -->

    <div class="sidebar">

      <!-- Sidebar user (optional) -->

      <div class="user-panel mt-3 pb-3 mb-3 d-flex">

        <div class="image">

          <img src="/template/admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">

        </div>

        <div class="info">

          <a href="#" class="d-block">{{Auth::user()->name}}</a>
           <span><a href="logout">Thoát</a></span>
        </div>

      </div>



      <!-- SidebarSearch Form -->

      <div class="form-inline">

        <div class="input-group" data-widget="sidebar-search">

          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">

          <div class="input-group-append">

            <button class="btn btn-sidebar">

              <i class="fas fa-search fa-fw"></i>

            </button>

          </div>

        </div><div class="sidebar-search-results"><div class="list-group"><a href="#" class="list-group-item"><div class="search-title"><strong class="text-light"></strong>N<strong class="text-light"></strong>o<strong class="text-light"></strong> <strong class="text-light"></strong>e<strong class="text-light"></strong>l<strong class="text-light"></strong>e<strong class="text-light"></strong>m<strong class="text-light"></strong>e<strong class="text-light"></strong>n<strong class="text-light"></strong>t<strong class="text-light"></strong> <strong class="text-light"></strong>f<strong class="text-light"></strong>o<strong class="text-light"></strong>u<strong class="text-light"></strong>n<strong class="text-light"></strong>d<strong class="text-light"></strong>!<strong class="text-light"></strong></div><div class="search-path"></div></a></div></div>

      </div>



      <!-- Sidebar Menu -->

      <nav class="mt-2">

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <!-- Add icons to the links using the .nav-icon class

               with font-awesome or any other icon font library -->
          @if(Auth::user()->Level==1)
          <li class="nav-item config">

            <a href="config/list" class="nav-link">

              <i class="nav-icon fas fa-tachometer-alt"></i>

              <p>

               Cấu hình

              

              </p>

            </a>

            

          </li>
          @endif

          

          <!-- <li class="nav-item review">

            <a href="review/list" class="nav-link">

              <i class="nav-icon fas fa-tachometer-alt"></i>

              <p>

                Đánh giá

              

              </p>

            </a>

            

          </li> -->

         

          

          <li class="nav-item danhmuc">

            <a href="#" class="nav-link">

              <i class="nav-icon fas fa-tachometer-alt"></i>

              <p>

                Danh mục

                <i class="right fas fa-angle-left"></i>

              </p>

            </a>

            <ul class="nav nav-treeview" style="display: none;">

              <li class="nav-item">

                <a href="danhmuc/list" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Danh sách danh mục  </p>

                </a>

              </li>

              <li class="nav-item">

                <a href="danhmuc/add" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Thêm danh mục</p>

                </a>

              </li>             

            </ul>

          </li>


          <li class="nav-item baiviet">

            <a href="#" class="nav-link">

              <i class="nav-icon fas fa-tachometer-alt"></i>

              <p>

                Bài viết

                <i class="right fas fa-angle-left"></i>

              </p>

            </a>

            <ul class="nav nav-treeview" style="display: none;">

              <li class="nav-item">

                <a href="baiviet/list" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Danh sách bài viết  </p>

                </a>

              </li>

              <li class="nav-item">

                <a href="baiviet/add" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Thêm bài viết</p>

                </a>

              </li>             

            </ul>

          </li>
          <li class="nav-item members business">

            <a href="#" class="nav-link">

              <i class="nav-icon fas fa-tachometer-alt"></i>

              <p>

                Business

                <i class="right fas fa-angle-left"></i>

              </p>

            </a>

            <ul class="nav nav-treeview" style="display: none;">

              <li class="nav-item">

                <a href="{{ route('businesses.index') }}" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Danh sách business  </p>

                </a>

              </li>

                         

            </ul>

          </li>
          <li class="nav-item members portfolio">

            <a href="#" class="nav-link">

              <i class="nav-icon fas fa-tachometer-alt"></i>

              <p>

                Memebers

                <i class="right fas fa-angle-left"></i>

              </p>

            </a>

            <ul class="nav nav-treeview" style="display: none;">

              <li class="nav-item">

                <a href="{{ route('members.index') }}" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Danh sách member  </p>

                </a>

              </li>

              <li class="nav-item">

                <a href="{{ route('portfolio.index') }}" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Sanh sách portfolio</p>

                </a>

              </li>             

            </ul>

          </li>
          @if(Auth::user()->Level==1)
          <li class="nav-item users">

            <a href="#" class="nav-link">

              <i class="nav-icon fas fa-tachometer-alt"></i>

              <p>

                User

                <i class="right fas fa-angle-left"></i>

              </p>

            </a>

            <ul class="nav nav-treeview" style="display: none;">

              <li class="nav-item">

                <a href="{{ route('users.index') }}" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Danh sách users  </p>

                </a>

              </li>

                         

            </ul>

          </li>
          @endif
         
          

          

          

          

          

          

          

          

          

          

          

          

          

          

          

          

          

          

          

          

          

          

          

          

          

          

        </ul>

      </nav>

      <!-- /.sidebar-menu -->

    </div>

    <!-- /.sidebar -->

  </aside>



  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper" style="min-height: 1669.19px;">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1>{{$title}}</h1>

          </div>

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item"><a href="#">Home</a></li>

              <li class="breadcrumb-item"><a href="#">{{$title}}</a></li>             

            </ol>

          </div>

        </div>

      </div><!-- /.container-fluid -->

    </section>



    <!-- Main content -->

    <section class="content">



      <div class="container-fluid">

        <div class="row">

            <div class="col-12">

              @include('admin.blocks.alert')

          		@yield('content')

            </div>

        </div>

      </div>

    </section>

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->



  <footer class="main-footer">

    <div class="float-right d-none d-sm-block">

      <b>Version</b> 4.1.0

    </div>

    <strong>Copyright © 2021-2025 <a href="https://www.facebook.com/khang.vuong.98/">Admin</a>.</strong> All rights reserved.

  </footer>

<div class="modal" id="modal_size" tabindex="-1" role="dialog">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title">Thêm Size</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <div class="form-group">

              <label><i class="fa fa-check-circle-o" aria-hidden="true"></i>Tên</label>

              <input type="text" required="required" placeholder="Nhập tên " class="form-control name_size" name="Name">

            </div>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-primary" onclick="save_size()">Thêm</button>

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>

      </div>

    </div>

  </div>

</div>

<div class="modal" id="modal_color" tabindex="-1" role="dialog">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title">Thêm Color</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <div class="form-group">

              <label><i class="fa fa-check-circle-o" aria-hidden="true"></i>Tên</label>

              <input type="text" required="required" placeholder="Nhập tên " class="form-control name_color" name="Name">

            </div>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-primary" onclick="save_color()">Save changes</button>

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>

    </div>

  </div>

</div>

@include('admin.blocks.footer')



  <script type="text/javascript">

    $(function(){

      $(".nav-sidebar li").each(function(){

          if($(this).hasClass("<?=$page?>"))

          {

            $(this).addClass("menu-is-opening menu-open");

              $(this).find(".nav-treeview").show();

          }

      })

      

    });

    function themsize()

{

  $("#modal_size").modal('show');

}

function themcolor()

{

  $("#modal_color").modal('show');

}

    function save_size()

    {

      var Name = $(".name_size").val();

       $.ajax({

          type:"POST",

          url:"/admin/product/insert_size",

          data:{Name:Name},

          dataType: 'json',

          success: function(msg){  

                  

               if(msg.success)

               {                 

                  $(".name_size").val("");

                  $("#modal_size").find(".thongbao").remove();

                  $("#modal_size .modal-body").prepend('<div class="thongbao alert alert-success" role="alert"> Thêm thanh công </div>');

                  $.get("/admin/product/get_list_size",{x:(new Date()).getTime()},function(d)

                  {         

                    $("select[name='size_attr[]']").html(d);                    

                  });

               }

               else

               {

                  $("#modal_size .modal-body").prepend('<div class="thongbao alert alert-danger" role="alert"> Đã tồn tại </div>');

               } 

          }      

        });

    }

    function save_color()

    {

      var Name = $(".name_color").val();

       $.ajax({

          type:"POST",

          url:"/admin/product/insert_color",

          data:{Name:Name},

          dataType: 'json',

          success: function(msg){  

                 

               if(msg.success)

               {                 

                  $(".name_color").val("");

                  $("#modal_color").find(".thongbao").remove();

                  $("#modal_color .modal-body").prepend('<div class="thongbao alert alert-success" role="alert"> Thêm thanh công </div>');

                  $.get("/admin/product/get_list_color",{x:(new Date()).getTime()},function(d)

                  {         

                    $("select[name='color_attr[]']").html(d);                    

                  });

               }

               else

               {

                  $("#modal_color .modal-body").prepend('<div class="thongbao alert alert-danger" role="alert"> Đã tồn tại </div>');

               } 

          }      

        });

    }

  </script>

