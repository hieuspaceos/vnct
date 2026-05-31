@extends('admin.index')
@section('content')
	<div class="d-flex justify-content-between align-items-center mb-4">
   
    <a href="{{ route('members.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm Member
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Slug</th>
                    <th>Số Portfolio</th>
                    <th>Ngôn ngữ</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                <tr>
                    <td>{{ $member->id }}</td>
                    <td>{{ $member->name }}</td>
                    <td><code>{{ $member->slug }}</code></td>
                    <td><span class="badge bg-info">{{ $member->portfolios_count }}</span></td>
                    <td>
                        <ul class="nav navbar-right panel_toolbox">
                        @foreach(App\Models\language::where("id","<>",App::currentLocale())->get() as $lang)
                            @php
                                // Lấy origin_id từ item hiện tại
                                $originId = $member->origin_id ?? $member->id;
                                
                                // Kiểm tra xem đã có bản dịch cho ngôn ngữ này chưa
                                $hasTranslation = DB::table('members')
                                    ->where(function($query) use ($originId, $member) {
                                        $query->where('origin_id', $originId)
                                              ->orWhere('id', $originId);
                                    })
                                    ->where('lang', $lang->id)
                                    ->where('id', '!=', $member->id) // Không tính bản ghi hiện tại
                                    ->first();
                            @endphp
                            
                            @if(!$hasTranslation)
                            <li>
                                <a href="/admin/members/copy-lang/{{$lang->id}}/{{ $originId }}" 
                                   title="Tạo bản {{ $lang->Name }}">
                                    <i class="fa fa-plus"></i> {{ $lang->Name }}
                                </a>
                            </li>
                            @else
                               <li>
                                <a href="{{ route('members.edit', $hasTranslation->id) }}" 
                                   title="Tạo bản {{ $lang->Name }}">
                                    <i class="fa fa-edit"></i> {{ $lang->Name }}
                                </a>
                            </li>  
                            @endif
                        @endforeach 
                        </ul>
                    </td>
                    <td>{{ $member->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('members.edit', $member) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        @if(Auth::user()->Level==1)
                        <form action="{{ route('members.destroy', $member) }}" method="POST" class="d-inline" 
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
                    <td colspan="6" class="text-center">Chưa có dữ liệu</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $members->links() }}
        </div>
    </div>
</div>
@endsection