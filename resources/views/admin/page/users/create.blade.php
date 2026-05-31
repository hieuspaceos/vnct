@extends('admin.index')


@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-primary">Thêm Người Dùng Mới</h4>
                </div>
                <div class="card-body">
                    {{-- Sửa lỗi Route --}}
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <!-- Tên -->
                        <div class="form-group">
                            <label for="name">Tên người dùng:</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mật khẩu -->
                        <div class="form-group">
                            <label for="password">Mật khẩu:</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Xác nhận Mật khẩu -->
                        <div class="form-group">
                            <label for="password_confirmation">Xác nhận Mật khẩu:</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>

                        <!-- Quyền Admin -->
                       <div class="form-group">
    <div class="">
        <select name="Level" class="form-control">
            <option value="1" {{ old('Level') == '1' ? 'selected' : '' }}>Admin</option>
            <option value="2" {{ old('Level') == '2' ? 'selected' : '' }}>Biên tập</option>
        </select>
    </div>
</div>

                        <!-- Nút Submit -->
                        <div class="pt-3 d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save mr-1"></i> Lưu Người Dùng
                            </button>
                            {{-- Sửa lỗi Route --}}
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection