<?php
// Kiểm tra đăng nhập (có thể thêm sau)
$is_logged_in = true; // Tạm thời cho phép truy cập

// Đường dẫn file JSON
$locale = \App::getLocale();
$json_file = public_path('template/files/contact_' . $locale . '.json');

//dd('template/files/contact_' . $locale . '.json');
// Đọc dữ liệu từ file JSON
if (file_exists($json_file)) {
    $json_content = file_get_contents($json_file);
    $data = json_decode($json_content, true);
} else {
    $data = [];
}
?>

<!-- Tiêu đề chính -->
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Tiêu đề chính (tiếng Pháp)</label>
    <input type="text" required="required" class="form-control" 
           placeholder="Nhập tiêu đề chính tiếng Pháp" 
           value="{{ $data['main_title'] ?? '' }}" 
           name="contact_main_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Lời chào (tiếng Pháp)</label>
    <input type="text" class="form-control" 
           placeholder="Nhập lời chào tiếng Pháp" 
           value="{{ $data['welcome_text'] ?? '' }}" 
           name="contact_welcome_text" />
</div>

<!-- Nội dung mô tả -->
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Nội dung mô tả (tiếng Pháp)</label>
    <textarea class="form-control" name="contact_description" rows="4">{{ $data['description'] ?? '' }}</textarea>
</div>

<!-- Thông tin liên hệ -->
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Email liên hệ</label>
    <input type="email" class="form-control" 
           placeholder="Nhập email liên hệ" 
           value="{{ $data['contact_email'] ?? '' }}" 
           name="contact_contact_email" />
</div>

<!-- Form labels (tiếng Pháp) -->
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Label Họ và tên</label>
    <input type="text" class="form-control" 
           placeholder="Nhập label họ và tên" 
           value="{{ $data['name_label'] ?? '' }}" 
           name="contact_name_label" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Label Email</label>
    <input type="text" class="form-control" 
           placeholder="Nhập label email" 
           value="{{ $data['email_label'] ?? '' }}" 
           name="contact_email_label" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Label Tiêu đề</label>
    <input type="text" class="form-control" 
           placeholder="Nhập label tiêu đề" 
           value="{{ $data['subject_label'] ?? '' }}" 
           name="contact_subject_label" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Label Nội dung</label>
    <input type="text" class="form-control" 
           placeholder="Nhập label nội dung" 
           value="{{ $data['content_label'] ?? '' }}" 
           name="contact_content_label" />
</div>

<!-- Text nút gửi -->
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Text nút gửi</label>
    <input type="text" class="form-control" 
           placeholder="Nhập text nút gửi" 
           value="{{ $data['submit_button'] ?? '' }}" 
           name="contact_submit_button" />
</div>

<!-- Google Maps Embed URL -->
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Google Maps Embed URL</label>
    <textarea class="form-control" name="contact_map_embed" rows="3">{{ $data['map_embed'] ?? '' }}</textarea>
    <small class="form-text text-muted">Dán mã embed từ Google Maps</small>
</div>

<!-- Messages thông báo -->
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Thông báo thành công</label>
    <input type="text" class="form-control" 
           placeholder="Nhập thông báo thành công" 
           value="{{ $data['success_message'] ?? '' }}" 
           name="contact_success_message" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Thông báo thất bại</label>
    <input type="text" class="form-control" 
           placeholder="Nhập thông báo thất bại" 
           value="{{ $data['failed_message'] ?? '' }}" 
           name="contact_failed_message" />
</div>