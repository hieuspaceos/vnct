@extends('admin.index')

@section('content')
    <div class="dataTable_wrapper table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th width="10%">ID Loại</th>
                    <th class="text-left">Tên danh mục</th>
                    <th width="20%">Loại danh mục</th>
                    <th width="20%">Ngôn ngữ</th>
                    <th width="15%">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allmenu as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td class="text-left">{{ $item->Name }}</td>
                    <td>
                        @if($item->Taxonomy == "tintuc")
                            Tin Tức
                        @elseif($item->Taxonomy == "duan")
                            Dự Án
                        @elseif($item->Taxonomy == "sanpham")
                            Sản phẩm
                        @elseif($item->Taxonomy == "page")
                            Page
                        @else
                            {{ $item->Taxonomy }}
                        @endif
                    </td>
                    <td>
                    	<ul class="nav navbar-right panel_toolbox">
                        @foreach(App\Models\language::where("id","<>",App::currentLocale())->get() as $lang)
						    @php
						        // Lấy origin_id từ item hiện tại
						        $originId = $item->origin_id ?? $item->id;
						        
						        // Kiểm tra xem đã có bản dịch cho ngôn ngữ này chưa
						        $hasTranslation = DB::table('terms')
						            ->where(function($query) use ($originId, $item) {
						                $query->where('origin_id', $originId)
						                      ->orWhere('id', $originId);
						            })
						            ->where('lang', $lang->id)
						            ->where('id', '!=', $item->id) // Không tính bản ghi hiện tại
						            ->exists();
						    @endphp
						    
						    @if(!$hasTranslation)
						    <li>
						        <a href="/admin/danhmuc/copy-lang/{{$lang->id}}/{{ $originId }}" 
						           title="Tạo bản {{ $lang->Name }}">
						            <i class="fa fa-plus"></i> {{ $lang->Name }}
						        </a>
						    </li>
                            @else
                               <li>
                                <a href="/admin/danhmuc/edit/{{ $originId }}" 
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
                                <a href="/admin/danhmuc/edit/{{ $item->id }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </li>
                            @if(Auth::user()->Level==1)
                            <li>
                                <a onclick="return confirm('Bạn có chắc muốn xóa không')" 
                                   href="/admin/danhmuc/delete/{{ $item->id }}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Phân trang -->
        @if($allmenu instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="text-center">
                {{ $allmenu->links() }}
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