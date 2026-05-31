@extends('admin.index')
@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4>{{ $title }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('members.store') }}" method="POST">
                    <input type="hidden" class="form-control" name="lang"  value="{{$lang}}">
            <input type="hidden" class="form-control" name="origin_id"  value="{{$member->id}}">
                    @csrf
                   
                    
                    <div class="mb-3">
                        <label class="form-label">Tên Member <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $member->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Slug sẽ tự động tạo từ tên</small>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Thêm
                        </button>
                        <a href="{{ route('members.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection