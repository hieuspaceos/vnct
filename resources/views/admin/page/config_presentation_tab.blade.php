<?php

// Kiểm tra đăng nhập (có thể thêm sau)
$is_logged_in = true; // Tạm thời cho phép truy cập

// Đường dẫn file JSON
$locale = \App::getLocale();
$json_file = public_path('template/files/presentation_' . $locale . '.json');

// Xử lý lưu dữ liệu

// Đọc dữ liệu từ file JSON
if (file_exists($json_file)) {
    $json_content = file_get_contents($json_file);
    $data = json_decode($json_content, true);
} else {
    $data = [];
}
?>
 <!-- Section 1 -->
                <div class="form-group">
                    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Section 1 - Tiêu đề chính</label>
                    <input type="text" required="required" class="form-control" 
                           placeholder="Nhập tiêu đề chính" 
                           value="{{ $data['section1_title'] ?? '' }}" 
                           name="presentation_section1_title" />
                </div>
                
                <div class="form-group">
                    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Section 1 - Phụ đề</label>
                    <input type="text" required="required" class="form-control" 
                           placeholder="Nhập phụ đề" 
                           value="{{ $data['section1_subtitle'] ?? '' }}" 
                           name="presentation_section1_subtitle" />
                </div>

                <!-- Section 2 - Logo -->
                <div class="form-group anhdaidien">
                    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Section 2 - Logo VNCT</label>
                    <div class="box-form">
                        <input type="text" name="presentation_section2_logo" id="avatarsection2_logo" readonly 
                               value="{{ $data['section2_logo'] ?? '' }}" 
                               class="form-control">
                        <button type="button" onclick="selectFileWithCKFinder_one('avatarsection2_logo','imageDDsection2_logo','avatar')">Chọn ảnh</button>
                        <a title="Xóa ảnh đang chọn" class="del-imageDD"><i class="fa fa-times" aria-hidden="true"></i></a>
                    </div>
                    <img class="img-anhdaidien imageDDsection2_logo" 
                         src="{{ $data['section2_logo'] ?? '/template/admin/image/noimage.jpg' }}"
                         style="max-width: 200px; margin-top: 10px;">
                </div>
                
                <div class="form-group">
                    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Section 2 - Tiêu đề VNCT</label>
                    <input type="text" class="form-control" 
                           value="{{ $data['section2_title'] ?? '' }}" 
                           name="presentation_section2_title" />
                </div>
                
                <div class="form-group">
                    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Section 2 - Phụ đề VNCT</label>
                    <input type="text" class="form-control" 
                           value="{{ $data['section2_subtitle'] ?? '' }}" 
                           name="presentation_section2_subtitle" />
                </div>
                
                <div class="form-group">
                    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Section 2 - Nội dung 1</label>
                    <textarea class="form-control" name="presentation_section2_content1" rows="3">{{ $data['section2_content1'] ?? '' }}</textarea>
                </div>
                
                <div class="form-group">
                    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Section 2 - Nội dung 2</label>
                    <textarea class="form-control" name="presentation_section2_content2" rows="3">{{ $data['section2_content2'] ?? '' }}</textarea>
                </div>         
