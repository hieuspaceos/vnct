@extends('admin.index')

@section('content')
    <div class="dataTable_wrapper">
        <!-- Thêm khung tìm kiếm -->
        <div class="row mb-3">
            <div class="col-md-12">
                <form method="GET" action="{{ url()->current() }}" class="form-inline">
                    <div class="input-group" style="width: 100%; max-width: 400px;">
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Tìm kiếm theo ID hoặc tên sản phẩm..." 
                               value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-search"></i> Tìm kiếm
                            </button>
                            @if(request('search'))
                            <a href="{{ url()->current() }}" class="btn btn-default">
                                <i class="fa fa-refresh"></i> Xóa
                            </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th class="text-left">Tên sản phẩm</th>
                    <th width="12%">Hình</th>
                    <th width="15%">Loại danh mục</th>
                    <th width="8%">Ngôn ngữ</th>
                    <th width="15%">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allPosts as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td class="text-left">{{ $item->Post_Title }}</td>
                    <td>
                        @if($item->Post_Thumb)
                            <img src="{{ $item->Post_Thumb }}" width="80" height="60" style="object-fit: cover;">
                        @else
                            <span class="text-muted">Không có ảnh</span>
                        @endif
                    </td>
                    <td>
                        @if($item->terms && count($item->terms) > 0)
                            @foreach($item->terms as $term)
                                <span class="badge badge-info">{{ $term->Name }}</span><br>
                            @endforeach
                        @else
                            <span class="text-muted">Chưa phân loại</span>
                        @endif
                    </td>
                    <td>
                        <!-- Cột ngôn ngữ - Hiển thị các nút thêm ngôn ngữ -->
                        <ul class="nav navbar-right panel_toolbox" style="margin-right: 0;">
                            @foreach(App\Models\language::where("id","<>",App::currentLocale())->get() as $lang)
                                @php
                                    // Lấy origin_id từ item hiện tại
                                    $originId = $item->origin_id ?? $item->id;                                   
                                    // Kiểm tra xem đã có bản dịch cho ngôn ngữ này chưa
                                    $hasTranslation = DB::table('posts')
                                        ->where(function($query) use ($originId, $item) {
                                            $query->where('origin_id', $originId)
                                                  ->orWhere('id', $originId);
                                        })
                                        ->where('lang', $lang->id)
                                        ->where('id', '!=', $item->id)
                                        ->first();
                                @endphp
                                
                                @if(!$hasTranslation)
                                <li>
                                    <a href="/admin/baiviet/copy-lang/{{$lang->id}}/{{ $originId }}" 
                                       title="Tạo bản {{ $lang->Name }}">
                                        <i class="fa fa-plus"></i> {{ $lang->Name }}
                                    </a>
                                </li>
                                @else
                                <li>
                                <a href="/admin/baiviet/edit/{{ $hasTranslation->id }}" 
                                   title="Tạo bản {{ $lang->Name }}">
                                    <i class="fa fa-edit"></i> {{ $lang->Name }}
                                </a>
                            </li>  
                                @endif
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a href="/admin/baiviet/edit/{{ $item->id }}" title="Sửa">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </li>
                            @if(Auth::user()->Level==1)
                            <li>
                                <a onclick="return confirm('Bạn có chắc muốn xóa không?')" 
                                   href="/admin/baiviet/delete/{{ $item->id }}" title="Xóa">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </li>
                            @endif
                            <li>
                                <a href="/admin/baiviet/copy/{{ $item->id }}" title="Sao chép">
                                    <i class="fa fa-clone"></i>
                                </a>
                            </li>
                            
                        </ul>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Phân trang -->
        @if($allPosts instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="text-center">
                {{ $allPosts->links() }}
            </div>
        @endif
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $(".delete_category").click(function(e) {        
            e.preventDefault(e);
            var url = $(this).attr("href");
            var id = $(this).attr("id");
            
            $.ajax({
                type: "POST",
                url: "ajax.php",
                data: {
                    check_category: "",
                    id: id
                },
                success: function(msg) {
                    console.log(msg);
                    if(msg.trim() == "khongco") {
                        window.location.href = url;
                    } else {
                        $(".background,.popup").css({"display":"block"});
                        $(".datapopup").empty();
                        $(".datapopup").append(msg);
                    }
                }
            }); 
        });
    });
</script>
@endsection