@extends('admin.index')
@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header">
                <h4>Sửa Portfolio: {{ $portfolio->name }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('portfolio.update', $portfolio) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Loại thành viên <span class="text-danger">*</span></label>
                            <select name="member_id" class="form-select @error('member_id') is-invalid @enderror" required>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}" 
                                        {{ old('member_id', $portfolio->member_id) == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('member_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tên <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $portfolio->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hình đại diện</label>
                            <div class="form-group anhdaidien">
                                <div class="box-form d-flex gap-2">
                                    <input type="text" name="avatar" id="avatar" readonly value="{{ old('avatar', $portfolio->avatar) }}" class="form-control @error('avatar') is-invalid @enderror">
                                    <button type="button" class="btn btn-primary" onclick="selectFileWithCKFinder('avatar','imageDD','portfolio:/')">
                                        <i class="fas fa-image"></i> Chọn ảnh
                                    </button>
                                    <a class="btn btn-danger del-imageDD" title="Xóa ảnh đang chọn">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <img class="img-anhdaidien mt-2" id="imageDD" 
                                 src="{{ $portfolio->avatar ? $portfolio->avatar : '/template/admin/image/noimage.jpg' }}" 
                                 style="max-width: 200px; border: 1px solid #ddd; padding: 5px;">
                            @error('avatar')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                       
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Loại</label>
                            @if($portfolio->lang==1)
                            <select name="type" class="form-select @error('type') is-invalid @enderror">
                                <option value="">-- Chọn loại --</option>
                                <option value="Negocio" {{ old('type', $portfolio->type) == 'Negocio' ? 'selected' : '' }}>Negocio</option>
                                <option value="Individual" {{ old('type', $portfolio->type) == 'Individual' ? 'selected' : '' }}>Individual</option>
                                <option value="Organización" {{ old('type', $portfolio->type) == 'Organización' ? 'selected' : '' }}>Organización</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @else
                             <select name="type" class="form-select @error('type') is-invalid @enderror">
                                <option value="">-- Chọn loại --</option>
                                <option value="Việc kinh doanh" {{ old('type', $portfolio->type) == 'Việc kinh doanh' ? 'selected' : '' }}>Việc kinh doanh</option>
                                <option value="Cá nhân" {{ old('type', $portfolio->type) == 'Cá nhân' ? 'selected' : '' }}>Cá nhân</option>
                                <option value="Tổ chức" {{ old('type', $portfolio->type) == 'Tổ chức' ? 'selected' : '' }}>Tổ chức</option>
                            </select>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $portfolio->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Họ và tên</label>
                            <input type="text" name="username" class="form-control" 
                                   value="{{ old('username', $portfolio->username) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Vị trí</label>
                            <input type="text" name="location" class="form-control" 
                                   value="{{ old('location', $portfolio->location) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Chức vụ</label>
                            <input type="text" name="position" class="form-control" 
                                   value="{{ old('position', $portfolio->position) }}">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Khu vực hoạt động</label>
                            <input type="text" name="area_of_operation" class="form-control" 
                                   value="{{ old('area_of_operation', $portfolio->area_of_operation) }}">
                        </div>
                        <div class="form-group mota">
                                <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Chi tiết </label>
                                <textarea  name="content" rows="5" >{{$portfolio->content}}</textarea>
                            </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Cập nhật
                        </button>
                        <a href="{{ route('portfolio.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script type="text/javascript">
        var content = CKEDITOR.replace('content' ,{
    uiColor : '#ebf2f6',
    language:'vi',      
    filebrowserImageBrowseUrl : '{{ route('ckfinder_browser') }}?resourceType=Images',          
    filebrowserImageUploadUrl : '{{ route('ckfinder_connector') }}?command=QuickUpload&type=Images',  
});
        function selectFileWithCKFinder( elementId, callback ,startupPath ) {
    CKFinder.popup( {
        chooseFiles: true,
        width: 800,
        height: 600,
        selectMultiple:false,
        startupPath: startupPath,
        onInit: function( finder ) {
            finder.on( 'files:choose', function( evt ) {
                var file = evt.data.files.first();
                $("#"+callback).attr("src",file.getUrl().replace("<?=env('APP_URL')?>",""));
                $("#"+elementId).val(file.getUrl().replace("<?=env('APP_URL')?>",""));
        
    } );
        }
}   );
}
</script>
@endsection