<?php
// Kiểm tra đăng nhập (có thể thêm sau)
$is_logged_in = true; // Tạm thời cho phép truy cập

// Đường dẫn file JSON
$locale = \App::getLocale();
$json_file = public_path('template/files/auth_' . $locale . '.json');

// Xử lý lưu dữ liệu (thêm sau)

// Đọc dữ liệu từ file JSON
if (file_exists($json_file)) {
    $json_content = file_get_contents($json_file);
    $data = json_decode($json_content, true);
} else {
    $data = [];
}
?>

<div class="form-group mb-3">
    <label>Tiêu đề Đăng nhập (Login Title)</label>
    <input type="text" class="form-control" name="auth_login_title" value="{{ $data['login_title'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Tên tài khoản hoặc Email (Username or Email)</label>
    <input type="text" class="form-control" name="auth_username_or_email" value="{{ $data['username_or_email'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Mật khẩu (Password)</label>
    <input type="text" class="form-control" name="auth_password" value="{{ $data['password'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Nút Đăng nhập (Login Button)</label>
    <input type="text" class="form-control" name="auth_login_button" value="{{ $data['login_button'] ?? '' }}" />
</div>

<hr>
<div class="form-group mb-3">
    <label>Tiêu đề Đăng ký (Register Title)</label>
    <input type="text" class="form-control" name="auth_register_title" value="{{ $data['register_title'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Tên doanh nghiệp (Company Name)</label>
    <input type="text" class="form-control" name="auth_company_name" value="{{ $data['company_name'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Mã số thuế (Tax Code)</label>
    <input type="text" class="form-control" name="auth_tax_code" value="{{ $data['tax_code'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Website</label>
    <input type="text" class="form-control" name="auth_website" value="{{ $data['website'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Lĩnh vực hoạt động (Industry)</label>
    <input type="text" class="form-control" name="auth_industry" value="{{ $data['industry'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Họ và tên người đại diện (Representative Name)</label>
    <input type="text" class="form-control" name="auth_representative_name" value="{{ $data['representative_name'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Chức vụ (Position)</label>
    <input type="text" class="form-control" name="auth_position" value="{{ $data['position'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Số điện thoại (Phone)</label>
    <input type="text" class="form-control" name="auth_phone" value="{{ $data['phone'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Email liên hệ (Contact Email)</label>
    <input type="text" class="form-control" name="auth_contact_email" value="{{ $data['contact_email'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Tên tài khoản (Username)</label>
    <input type="text" class="form-control" name="auth_username" value="{{ $data['username'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Xác nhận mật khẩu (Password Confirmation)</label>
    <input type="text" class="form-control" name="auth_password_confirmation" value="{{ $data['password_confirmation'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Mô tả ngắn (Description)</label>
    <textarea class="form-control" name="auth_description" rows="3">{{ $data['description'] ?? '' }}</textarea>
</div>

<div class="form-group mb-3">
    <label>Nút Đăng ký (Register Button)</label>
    <input type="text" class="form-control" name="auth_register_button" value="{{ $data['register_button'] ?? '' }}" />
</div>

<hr>
<div class="form-group mb-3">
    <label>Trạng thái đang tải (Loading)</label>
    <input type="text" class="form-control" name="auth_loading" value="{{ $data['loading'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Đăng nhập thành công (Login Success)</label>
    <input type="text" class="form-control" name="auth_login_success" value="{{ $data['login_success'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Đăng ký thành công (Register Success)</label>
    <input type="text" class="form-control" name="auth_register_success" value="{{ $data['register_success'] ?? '' }}" />
</div>

<!-- Các thông báo bổ sung từ auth_2.json -->
<hr>
<hr>
<h5>Thông báo lỗi / thành công</h5>

<div class="form-group mb-3">
    <label>Thông báo - Đăng ký thành công (dangky_thanhcong)</label>
    <input type="text" class="form-control" name="auth_dangky_thanhcong" value="{{ $data['dangky_thanhcong'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Thông báo - Đăng nhập thành công (dangnhap_thanhcong)</label>
    <input type="text" class="form-control" name="auth_dangnhap_thanhcong" value="{{ $data['dangnhap_thanhcong'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Lỗi - Mã số thuế đã tồn tại (ma_so_thue_da_ton_tai)</label>
    <input type="text" class="form-control" name="auth_ma_so_thue_da_ton_tai" value="{{ $data['ma_so_thue_da_ton_tai'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Lỗi - Số điện thoại đã được đăng ký (so_dien_thoai_da_dang_ky)</label>
    <input type="text" class="form-control" name="auth_so_dien_thoai_da_dang_ky" value="{{ $data['so_dien_thoai_da_dang_ky'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Lỗi - Email đã được đăng ký (email_da_dang_ky)</label>
    <input type="text" class="form-control" name="auth_email_da_dang_ky" value="{{ $data['email_da_dang_ky'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Lỗi - Tên tài khoản đã tồn tại (ten_tai_khoan_da_ton_tai)</label>
    <input type="text" class="form-control" name="auth_ten_tai_khoan_da_ton_tai" value="{{ $data['ten_tai_khoan_da_ton_tai'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Lỗi - Xác nhận mật khẩu không khớp (xac_nhan_mat_khau_khong_khop)</label>
    <input type="text" class="form-control" name="auth_xac_nhan_mat_khau_khong_khop" value="{{ $data['xac_nhan_mat_khau_khong_khop'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Lỗi - Tài khoản không tồn tại (tai_khoan_khong_ton_tai)</label>
    <input type="text" class="form-control" name="auth_tai_khoan_khong_ton_tai" value="{{ $data['tai_khoan_khong_ton_tai'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Thông báo - Liên hệ admin (lien_he_admin)</label>
    <input type="text" class="form-control" name="auth_lien_he_admin" value="{{ $data['lien_he_admin'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Thông báo - Tài khoản bị từ chối (tai_khoan_tu_choi)</label>
    <input type="text" class="form-control" name="auth_tai_khoan_tu_choi" value="{{ $data['tai_khoan_tu_choi'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Lỗi - Mật khẩu không chính xác (mat_khau_khong_chinh_xac)</label>
    <input type="text" class="form-control" name="auth_mat_khau_khong_chinh_xac" value="{{ $data['mat_khau_khong_chinh_xac'] ?? '' }}" />
</div>
<div class="form-group mb-3">
    <label>Tiêu đề thông báo từ chối (thong_bao_tu_choi_tieu_de)</label>
    <input type="text" class="form-control" name="auth_thong_bao_tu_choi_tieu_de" value="{{ $data['thong_bao_tu_choi_tieu_de'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Lời chào (chao_doanh_nghiep)</label>
    <input type="text" class="form-control" name="auth_chao_doanh_nghiep" value="{{ $data['chao_doanh_nghiep'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Cảm ơn quan tâm (cam_on_quan_tam)</label>
    <input type="text" class="form-control" name="auth_cam_on_quan_tam" value="{{ $data['cam_on_quan_tam'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Nội dung từ chối (thong_bao_tu_choi_noi_dung)</label>
    <input type="text" class="form-control" name="auth_thong_bao_tu_choi_noi_dung" value="{{ $data['thong_bao_tu_choi_noi_dung'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Nhãn Lý do từ chối (ly_do_tu_choi)</label>
    <input type="text" class="form-control" name="auth_ly_do_tu_choi" value="{{ $data['ly_do_tu_choi'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Hỗ trợ thắc mắc (ho_tro_thac_mac)</label>
    <input type="text" class="form-control" name="auth_ho_tro_thac_mac" value="{{ $data['ho_tro_thac_mac'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Gợi ý đăng ký lại (dang_ky_lai)</label>
    <input type="text" class="form-control" name="auth_dang_ky_lai" value="{{ $data['dang_ky_lai'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Tiêu đề chúc mừng (email_success_title)</label>
    <input type="text" class="form-control" name="auth_email_success_title" value="{{ $data['email_success_title'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Lời chào mừng thành công (email_success_welcome)</label>
    <input type="text" class="form-control" name="auth_email_success_welcome" value="{{ $data['email_success_welcome'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Nhãn Email đăng nhập (email_success_login_email)</label>
    <input type="text" class="form-control" name="auth_email_success_login_email" value="{{ $data['email_success_login_email'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Nhãn Người đại diện (email_success_representative)</label>
    <input type="text" class="form-control" name="auth_email_success_representative" value="{{ $data['email_success_representative'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Nhãn Ngày duyệt (email_success_approval_date)</label>
    <input type="text" class="form-control" name="auth_email_success_approval_date" value="{{ $data['email_success_approval_date'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Nút Đăng nhập ngay (email_success_login_now)</label>
    <input type="text" class="form-control" name="auth_email_success_login_now" value="{{ $data['email_success_login_now'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Tiêu đề Lưu ý (email_success_note_title)</label>
    <input type="text" class="form-control" name="auth_email_success_note_title" value="{{ $data['email_success_note_title'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Lưu ý 1 (email_success_note_1)</label>
    <input type="text" class="form-control" name="auth_email_success_note_1" value="{{ $data['email_success_note_1'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Lưu ý 2 (email_success_note_2)</label>
    <input type="text" class="form-control" name="auth_email_success_note_2" value="{{ $data['email_success_note_2'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Lưu ý 3 (email_success_note_3)</label>
    <input type="text" class="form-control" name="auth_email_success_note_3" value="{{ $data['email_success_note_3'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Lưu ý 4 (email_success_note_4)</label>
    <input type="text" class="form-control" name="auth_email_success_note_4" value="{{ $data['email_success_note_4'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Câu hỏi hỗ trợ (email_success_question)</label>
    <input type="text" class="form-control" name="auth_email_success_question" value="{{ $data['email_success_question'] ?? '' }}" />
</div>

<div class="form-group mb-3">
    <label>Lời chúc cuối thư (email_success_wish)</label>
    <input type="text" class="form-control" name="auth_email_success_wish" value="{{ $data['email_success_wish'] ?? '' }}" />
</div>