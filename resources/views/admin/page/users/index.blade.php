@extends('admin.index')


@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="d-flex align-items-center justify-content-between p-3">
                    <h4 class="m-0 font-weight-bold text-primary">Quản Lý Tài khoản</h4>
                    {{-- Sửa lỗi Route --}}
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i> Thêm Tài khoản
                    </a>
                </div>
                
                <div class="card-body">
                    
                   

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th class="text-center" width="15%">Quyền Hạn</th>
                                    <th class="text-center" width="15%">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td class="align-middle">{{ $user->id }}</td>
                                    <td class="align-middle">{{ $user->name }}</td>
                                    <td class="align-middle">{{ $user->email }}</td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-{{ $user->is_admin ? 'danger' : 'success' }}">
                                            {{ $user->Level==1 ? 'Admin' : 'Biên tập' }}
                                        </span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex justify-content-center">
                                            <!-- Nút Edit -->
                                            {{-- Sửa lỗi Route --}}
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-info mr-2" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <!-- Nút Delete (Form POST) -->
                                            {{-- Sửa lỗi Route --}}
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng {{ $user->name }}?');" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Phân trang -->
                <div class="card-footer clearfix">
                    {{ $users->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection