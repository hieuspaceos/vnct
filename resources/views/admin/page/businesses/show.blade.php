{{-- resources/views/admin/businesses/show.blade.php --}}
@extends('admin.index')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Chi tiết doanh nghiệp</h4>
    <a href="{{ route('businesses.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="35%">ID</th>
                        <td>{{ $business->id }}</td>
                    </tr>
                    <tr>
                        <th>Tên doanh nghiệp</th>
                        <td>{{ $business->company_name }}</td>
                    </tr>
                    <tr>
                        <th>Mã số thuế</th>
                        <td>{{ $business->tax_code }}</td>
                    </tr>
                    <tr>
                        <th>Website</th>
                        <td>
                            @if($business->website)
                                <a href="{{ $business->website }}" target="_blank">{{ $business->website }}</a>
                            @else
                                <em>Chưa cập nhật</em>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Lĩnh vực hoạt động</th>
                        <td>{{ $business->industry }}</td>
                    </tr>
                    <tr>
                        <th>Họ tên người đại diện</th>
                        <td>{{ $business->representative_name }}</td>
                    </tr>
                    <tr>
                        <th>Chức vụ</th>
                        <td>{{ $business->position }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="35%">Số điện thoại</th>
                        <td>{{ $business->phone }}</td>
                    </tr>
                    <tr>
                        <th>Email liên hệ</th>
                        <td>{{ $business->email }}</td>
                    </tr>
                    <tr>
                        <th>Tên tài khoản</th>
                        <td>{{ $business->username }}</td>
                    </tr>
                    <tr>
                        <th>Trạng thái</th>
                        <td>
                            @if($business->status == 'pending')
                                <span class="badge bg-warning">Chờ duyệt</span>
                            @elseif($business->status == 'approved')
                                <span class="badge bg-success">Đã duyệt</span>
                            @else
                                <span class="badge bg-danger">Từ chối</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Ngày đăng ký</th>
                        <td>{{ $business->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    @if($business->approved_at)
                    <tr>
                        <th>Ngày duyệt</th>
                        <td>{{ $business->approved_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Cập nhật lần cuối</th>
                        <td>{{ $business->updated_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                </table>
            </div>
            @if($business->description)
            <div class="col-12">
                <div class="card mt-3">
                    <div class="card-header">
                        <strong>Mô tả doanh nghiệp</strong>
                    </div>
                    <div class="card-body">
                        {{ $business->description }}
                    </div>
                </div>
            </div>
            @endif
        </div>

        @if($business->status == 'pending')
        <div class="mt-4 text-center">
            <button class="btn btn-success approve-btn" data-id="{{ $business->id }}">
                <i class="fas fa-check"></i> Duyệt doanh nghiệp
            </button>
            <button class="btn btn-danger reject-btn" data-id="{{ $business->id }}">
                <i class="fas fa-times"></i> Từ chối
            </button>
        </div>
        @endif
    </div>
</div>
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Từ chối doanh nghiệp</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Lý do từ chối:</label>
                    <textarea id="rejectReason" class="form-control" rows="4" placeholder="Nhập lý do từ chối..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-danger" id="confirmRejectBtn">Xác nhận từ chối</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Duyệt doanh nghiệp
        $('.approve-btn').click(function() {
            if(confirm('Bạn có chắc muốn duyệt doanh nghiệp này?')) {
                let id = $(this).data('id');
                let btn = $(this);
                
                $.ajax({
                    url: `/admin/businesses/${id}/approve`,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        btn.html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled', true);
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function() {
                        alert('Có lỗi xảy ra, vui lòng thử lại');
                        btn.html('<i class="fas fa-check"></i> Duyệt doanh nghiệp').prop('disabled', false);
                    }
                });
            }
        });
        $('.reject-btn').click(function() {
            currentRejectId = $(this).data('id');
            $('#rejectModal').modal('show');
        });
        // Từ chối
        $('#confirmRejectBtn').click(function() {
            let reason = $('#rejectReason').val();
            if(!reason) {
                alert('Vui lòng nhập lý do từ chối');
                return;
            }
            
            $.ajax({
                url: `/admin/businesses/${currentRejectId}/reject`,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    reason: reason
                },
                beforeSend: function() {
                    $('#confirmRejectBtn').html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled', true);
                },
                success: function(response) {
                    alert(response.message);
                    $('#rejectModal').modal('hide');
                    location.reload();
                },
                error: function() {
                    alert('Có lỗi xảy ra, vui lòng thử lại');
                    $('#confirmRejectBtn').html('Xác nhận từ chối').prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection