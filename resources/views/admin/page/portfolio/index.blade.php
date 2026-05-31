@extends('admin.index')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
   <a href="{{ route('portfolio.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm Portfolio
    </a>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hình đại diện</th>
                    <th>Tên</th>
                    <th>Loại thành viên</th>
                    <th>Ngôn ngữ</th>
                    <th>Email</th>
                    <th>vị trí</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($portfolios as $portfolio)
                <tr>
                    <td>{{ $portfolio->id }}</td>
                    <td>
                        @if($portfolio->avatar)
                            <img src="{{ $portfolio->avatar }}" 
                                 alt="Avatar" class="rounded" width="50">
                        @else
                            <i class="fas fa-user-circle fa-2x text-muted"></i>
                        @endif
                    </td>
                    <td>{{ $portfolio->name }}</td>
                    <td><span class="badge bg-primary">{{ $portfolio->member->name }}</span></td>
                    <td>
                        <ul class="nav navbar-right panel_toolbox">
                        @foreach(App\Models\language::where("id","<>",App::currentLocale())->get() as $lang)
                            @php
                                // Lấy origin_id từ item hiện tại
                                $originId = $portfolio->origin_id ?? $portfolio->id;
                                
                                // Kiểm tra xem đã có bản dịch cho ngôn ngữ này chưa
                                $hasTranslation = DB::table('portfolio')
                                    ->where(function($query) use ($originId, $portfolio) {
                                        $query->where('origin_id', $originId)
                                              ->orWhere('id', $originId);
                                    })
                                    ->where('lang', $lang->id)
                                    ->where('id', '!=', $portfolio->id) // Không tính bản ghi hiện tại
                                    ->first();
                            @endphp
                            
                            @if(!$hasTranslation)
                            <li>
                                <a href="/admin/portfolio/copy-lang/{{$lang->id}}/{{ $originId }}" 
                                   title="Tạo bản {{ $lang->Name }}">
                                    <i class="fa fa-plus"></i> {{ $lang->Name }}
                                </a>
                            </li>
                            @else
                               <li>
                                <a href="{{ route('portfolio.edit', $hasTranslation->id) }}" 
                                   title="Tạo bản {{ $lang->Name }}">
                                    <i class="fa fa-edit"></i> {{ $lang->Name }}
                                </a>
                            </li>  
                            @endif
                        @endforeach 
                        </ul>
                    </td>
                    <td>{{ $portfolio->email }}</td>
                    <td>{{ $portfolio->location }}</td>
                    <td>
                        <a href="{{ route('portfolio.edit', $portfolio) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        @if(Auth::user()->Level==1)
                        <form action="{{ route('portfolio.destroy', $portfolio) }}" method="POST" class="d-inline" 
                              onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Chưa có dữ liệu</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $portfolios->links() }}
        </div>
    </div>
</div>
@endsection