@extends('admin.index')


@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-warning">Chỉnh Sửa Người Dùng: {{ $user->name }}</h4>
                </div>
                <div class="card-body">
                    {{-- Sửa lỗi Route --}}
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Tên -->
                        <div class="form-group">
                            <label for="name">Tên người dùng:</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mật khẩu (Không bắt buộc) -->
                        <div class="form-group">
                            <label for="password">Mật khẩu (Để trống nếu không thay đổi):</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Xác nhận Mật khẩu -->
                        <div class="form-group">
                            <label for="password_confirmation">Xác nhận Mật khẩu:</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            <small class="form-text text-muted">Chỉ cần nhập nếu bạn thay đổi mật khẩu.</small>
                        </div>

                        <!-- Quyền Admin -->
                        <div class="form-group">
    <div class="">
        <select name="Level" class="form-control">
            {{-- Kiểm tra old('Level') trước, nếu không có thì dùng $user->Level --}}
            <option value="1" {{ (old('Level') ?? $user->Level) == '1' ? 'selected' : '' }}>Admin</option>
            <option value="2" {{ (old('Level') ?? $user->Level) == '2' ? 'selected' : '' }}>Biên tập</option>
        </select>
    </div>
</div>

                        <!-- Nút Submit -->
                        <div class="pt-3 d-flex justify-content-between">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-sync-alt mr-1"></i> Cập Nhật Người Dùng
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