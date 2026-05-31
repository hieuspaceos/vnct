{{-- resources/views/admin/businesses/index.blade.php --}}
@extends('admin.index')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="btn-group" role="group">
            <a href="{{ route('businesses.index', ['status' => 'all']) }}" 
               class="btn btn-secondary {{ $status == 'all' ? 'active' : '' }}">
                Tất cả
            </a>
            <a href="{{ route('businesses.index', ['status' => 'pending']) }}" 
               class="btn btn-warning {{ $status == 'pending' ? 'active' : '' }}">
                Chờ duyệt
            </a>
            <a href="{{ route('businesses.index', ['status' => 'approved']) }}" 
               class="btn btn-success {{ $status == 'approved' ? 'active' : '' }}">
                Đã duyệt
            </a>
            <a href="{{ route('businesses.index', ['status' => 'rejected']) }}" 
               class="btn btn-danger {{ $status == 'rejected' ? 'active' : '' }}">
                Từ chối
            </a>
        </div>
    </div>
    <!-- <a href="{{ route('businesses.stats') }}" class="btn btn-info">
        <i class="fas fa-chart-bar"></i> Thống kê
    </a> -->
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên doanh nghiệp</th>
                    <th>Mã số thuế</th>
                    <th>Người đại diện</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Trạng thái</th>
                    <th>Ngày đăng ký</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($businesses as $business)
                <tr>
                    <td>{{ $business->id }}</td>
                    <td>
                        <strong>{{ $business->company_name }}</strong>
                        @if($business->website)
                            <br>
                            <small><a href="{{ $business->website }}" target="_blank">{{ $business->website }}</a></small>
                        @endif
                    </td>
                    <td>{{ $business->tax_code }}</td>
                    <td>
                        {{ $business->representative_name }}
                        <br>
                        <small class="text-muted">{{ $business->position }}</small>
                    </td>
                    <td>{{ $business->email }}</td>
                    <td>{{ $business->phone }}</td>
                    <td>
                        @if($business->status == 'pending')
                            <span class="badge bg-warning">Chờ duyệt</span>
                        @elseif($business->status == 'approved')
                            <span class="badge bg-success">Đã duyệt</span>
                        @else
                            <span class="badge bg-danger">Từ chối</span>
                        @endif
                    </td>
                    <td>
                        {{ $business->created_at->format('d/m/Y') }}
                        <br>
                        <small class="text-muted">{{ $business->created_at->format('H:i') }}</small>
                    </td>
                    <td>
                        <a href="{{ route('businesses.show', $business->id) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($business->status == 'pending')
                            <button class="btn btn-sm btn-success approve-btn" data-id="{{ $business->id }}">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-sm btn-danger reject-btn" data-id="{{ $business->id }}">
                                <i class="fas fa-times"></i>
                            </button>
                        @endif
                        @if(Auth::user()->Level == 1)
                            <button class="btn btn-sm btn-dark delete-btn" data-id="{{ $business->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Chưa có dữ liệu doanh nghiệp</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $businesses->appends(['status' => $status])->links() }}
        </div>
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
    let currentRejectId = null;
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
                        btn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function() {
                        alert('Có lỗi xảy ra, vui lòng thử lại');
                        btn.html('<i class="fas fa-check"></i>').prop('disabled', false);
                    }
                });
            }
        });
        $('.reject-btn').click(function() {
            currentRejectId = $(this).data('id');
            $('#rejectModal').modal('show');
        });
        // Xác nhận từ chối
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
        // Từ chối
        // $('.reject-btn').click(function() {
        //     if(confirm('Bạn có chắc muốn từ chối doanh nghiệp này?')) {
        //         let id = $(this).data('id');
        //         let btn = $(this);
                
        //         $.ajax({
        //             url: `/admin/businesses/${id}/reject`,
        //             method: 'POST',
        //             data: {
        //                 _token: $('meta[name="csrf-token"]').attr('content')
        //             },
        //             beforeSend: function() {
        //                 btn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
        //             },
        //             success: function(response) {
        //                 alert(response.message);
        //                 location.reload();
        //             },
        //             error: function() {
        //                 alert('Có lỗi xảy ra, vui lòng thử lại');
        //                 btn.html('<i class="fas fa-times"></i>').prop('disabled', false);
        //             }
        //         });
        //     }
        // });

        // Xóa
        $('.delete-btn').click(function() {
            if(confirm('Bạn có chắc muốn xóa doanh nghiệp này? Hành động này không thể hoàn tác!')) {
                let id = $(this).data('id');
                let btn = $(this);
                
                $.ajax({
                    url: `/admin/businesses/${id}`,
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        btn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function() {
                        alert('Có lỗi xảy ra, vui lòng thử lại');
                        btn.html('<i class="fas fa-trash"></i>').prop('disabled', false);
                    }
                });
            }
        });
    });
</script>
@endsection