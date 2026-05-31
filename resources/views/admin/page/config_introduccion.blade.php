<?php
// Kiểm tra đăng nhập (có thể thêm sau)
$is_logged_in = true; // Tạm thời cho phép truy cập

// Đường dẫn file JSON
$locale = \App::getLocale();
$json_file = public_path('template/files/introduccion_' . $locale . '.json');

// Xử lý lưu dữ liệu

// Đọc dữ liệu từ file JSON
if (file_exists($json_file)) {
    $json_content = file_get_contents($json_file);
    $data = json_decode($json_content, true);
} else {
    $data = [];
}
?>

<!-- Phần Giới thiệu -->
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Tiêu đề chính giới thiệu</label>
    <input type="text" required="required" class="form-control" 
           placeholder="Nhập tiêu đề chính giới thiệu" 
           value="{{ $data['intro_title'] ?? '' }}" 
           name="intro_intro_title" /> <!-- THÊM PREFIX -->
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Nội dung giới thiệu</label>
    <textarea class="form-control" name="intro_intro_content" rows="5">{{ $data['intro_content'] ?? '' }}</textarea>
</div>

<!-- Chiến lược -->
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Tiêu đề chiến lược</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề chiến lược" 
           value="{{ $data['strategy_title'] ?? '' }}" 
           name="intro_strategy_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Chiến lược 1 - Tiêu đề</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề chiến lược 1" 
           value="{{ $data['strategy1_title'] ?? '' }}" 
           name="intro_strategy1_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Chiến lược 1 - Nội dung</label>
    <textarea class="form-control" name="intro_strategy1_content" rows="3">{{ $data['strategy1_content'] ?? '' }}</textarea>
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Chiến lược 2 - Tiêu đề</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề chiến lược 2" 
           value="{{ $data['strategy2_title'] ?? '' }}" 
           name="intro_strategy2_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Chiến lược 2 - Nội dung</label>
    <textarea class="form-control" name="intro_strategy2_content" rows="3">{{ $data['strategy2_content'] ?? '' }}</textarea>
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Chiến lược 3 - Tiêu đề</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề chiến lược 3" 
           value="{{ $data['strategy3_title'] ?? '' }}" 
           name="intro_strategy3_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Chiến lược 3 - Nội dung</label>
    <textarea class="form-control" name="intro_strategy3_content" rows="3">{{ $data['strategy3_content'] ?? '' }}</textarea>
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Chiến lược 4 - Tiêu đề</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề chiến lược 4" 
           value="{{ $data['strategy4_title'] ?? '' }}" 
           name="intro_strategy4_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Chiến lược 4 - Nội dung</label>
    <textarea class="form-control" name="intro_strategy4_content" rows="3">{{ $data['strategy4_content'] ?? '' }}</textarea>
</div>

<!-- Tiêu đề các phần khác -->
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Tiêu đề Hội đồng quản trị</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề Hội đồng quản trị" 
           value="{{ $data['board_title'] ?? '' }}" 
           name="intro_board_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> data Hội đồng quản trị</label>
    @php
       $Member =  App\Models\Member::all();
    @endphp
    <select name="intro_board_data" class="form-control">
    <option value="">-- Chọn Member --</option>
    @foreach($Member as $item)
        <option value="{{ $item->id }}" 
            {{ isset($data['board_data']) && $data['board_data'] == $item->id ? 'selected' : '' }}>
            {{ $item->name }}
        </option>
    @endforeach
</select>
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Tiêu đề Thành viên chính thức</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề Thành viên chính thức" 
           value="{{ $data['members_title'] ?? '' }}" 
           name="intro_members_title" />
</div>
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> data Thành viên chính thức</label>
    @php
       $Member =  App\Models\Member::all();
    @endphp
    <select name="intro_members_data" class="form-control">
    <option value="">-- Chọn Member --</option>
    @foreach($Member as $item)
        <option value="{{ $item->id }}" 
            {{ isset($data['members_data']) && $data['members_data'] == $item->id ? 'selected' : '' }}>
            {{ $item->name }}
        </option>
    @endforeach
</select>
</div>
<!-- Phần Domaines -->
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Tiêu đề Domaines</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề Domaines" 
           value="{{ $data['domaines_title'] ?? '' }}" 
           name="intro_domaines_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Domaines 1 - Nội dung</label>
    <textarea class="form-control" name="intro_domaines1_content" rows="2">{{ $data['domaines1_content'] ?? '' }}</textarea>
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Domaines 2 - Nội dung</label>
    <textarea class="form-control" name="intro_domaines2_content" rows="2">{{ $data['domaines2_content'] ?? '' }}</textarea>
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Domaines 3 - Nội dung</label>
    <textarea class="form-control" name="intro_domaines3_content" rows="2">{{ $data['domaines3_content'] ?? '' }}</textarea>
</div>

<!-- Phần Responsabilités -->
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Tiêu đề Responsabilités</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề Responsabilités" 
           value="{{ $data['responsabilities_title'] ?? '' }}" 
           name="intro_responsabilities_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Responsabilité 1 - Nội dung</label>
    <textarea class="form-control" name="intro_responsabilities1_content" rows="2">{{ $data['responsabilities1_content'] ?? '' }}</textarea>
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Responsabilité 2 - Nội dung</label>
    <textarea class="form-control" name="intro_responsabilities2_content" rows="2">{{ $data['responsabilities2_content'] ?? '' }}</textarea>
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Responsabilité 3 - Nội dung</label>
    <textarea class="form-control" name="intro_responsabilities3_content" rows="2">{{ $data['responsabilities3_content'] ?? '' }}</textarea>
</div>

<!-- Phần 5W -->
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Tiêu đề 5W</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề 5W" 
           value="{{ $data['section5w_title'] ?? '' }}" 
           name="intro_section5w_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Phụ đề 5W</label>
    <input type="text" class="form-control" 
           placeholder="Nhập phụ đề 5W" 
           value="{{ $data['section5w_subtitle'] ?? '' }}" 
           name="intro_section5w_subtitle" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> What? Tiêu đề</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề What?" 
           value="{{ $data['what_title'] ?? '' }}" 
           name="intro_what_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> What? Nội dung</label>
    <textarea class="form-control" name="intro_what_content" rows="3">{{ $data['what_content'] ?? '' }}</textarea>
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> HOW? Tiêu đề</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề HOW?" 
           value="{{ $data['how_title'] ?? '' }}" 
           name="intro_how_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> HOW? Nội dung 1</label>
    <textarea class="form-control" name="intro_how_content1" rows="2">{{ $data['how_content1'] ?? '' }}</textarea>
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> HOW? Nội dung 2</label>
    <textarea class="form-control" name="intro_how_content2" rows="2">{{ $data['how_content2'] ?? '' }}</textarea>
</div>

<!-- Activités pros -->
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Activités pros - Tiêu đề</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề Activités pros" 
           value="{{ $data['pros_title'] ?? '' }}" 
           name="intro_pros_title" />
</div>

@for($i = 1; $i <= 5; $i++)
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Activités pros - Item {{ $i }}</label>
    <input type="text" class="form-control" 
           placeholder="Nhập nội dung item {{ $i }}" 
           value="{{ $data['pros_item' . $i] ?? '' }}" 
           name="intro_pros_item{{ $i }}" />
</div>
@endfor

<!-- Activités Promotion -->
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Activités Promotion - Tiêu đề</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề Activités Promotion" 
           value="{{ $data['promo_title'] ?? '' }}" 
           name="intro_promo_title" />
</div>

@for($i = 1; $i <= 3; $i++)
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Activités Promotion - Item {{ $i }}</label>
    <input type="text" class="form-control" 
           placeholder="Nhập nội dung item {{ $i }}" 
           value="{{ $data['promo_item' . $i] ?? '' }}" 
           name="intro_promo_item{{ $i }}" />
</div>
@endfor

<!-- Where, When, Who boxes -->
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Where - Tiêu đề</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề Where" 
           value="{{ $data['where_title'] ?? '' }}" 
           name="intro_where_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Where - Nội dung tiếng Việt</label>
    <input type="text" class="form-control" 
           placeholder="Nhập nội dung tiếng Việt" 
           value="{{ $data['where_vn'] ?? '' }}" 
           name="intro_where_vn" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Where - Nội dung tiếng Pháp</label>
    <input type="text" class="form-control" 
           placeholder="Nhập nội dung tiếng Pháp" 
           value="{{ $data['where_fr'] ?? '' }}" 
           name="intro_where_fr" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> When - Tiêu đề</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề When" 
           value="{{ $data['when_title'] ?? '' }}" 
           name="intro_when_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> When - Nội dung 1 tiếng Việt</label>
    <input type="text" class="form-control" 
           placeholder="Nhập nội dung 1 tiếng Việt" 
           value="{{ $data['when_vn1'] ?? '' }}" 
           name="intro_when_vn1" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> When - Nội dung 1 tiếng Pháp</label>
    <input type="text" class="form-control" 
           placeholder="Nhập nội dung 1 tiếng Pháp" 
           value="{{ $data['when_fr1'] ?? '' }}" 
           name="intro_when_fr1" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> When - Nội dung 2 tiếng Việt</label>
    <input type="text" class="form-control" 
           placeholder="Nhập nội dung 2 tiếng Việt" 
           value="{{ $data['when_vn2'] ?? '' }}" 
           name="intro_when_vn2" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> When - Nội dung 2 tiếng Pháp</label>
    <input type="text" class="form-control" 
           placeholder="Nhập nội dung 2 tiếng Pháp" 
           value="{{ $data['when_fr2'] ?? '' }}" 
           name="intro_when_fr2" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Who - Tiêu đề</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề Who" 
           value="{{ $data['who_title'] ?? '' }}" 
           name="intro_who_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Who - Nội dung</label>
    <textarea class="form-control" name="intro_who_content" rows="3">{{ $data['who_content'] ?? '' }}</textarea>
</div>

<!-- Video và Văn hóa Du lịch -->
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Tiêu đề Video</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề Video" 
           value="{{ $data['video_title'] ?? '' }}" 
           name="intro_video_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Tiêu đề Văn hóa Du lịch</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề Văn hóa Du lịch" 
           value="{{ $data['culture_title'] ?? '' }}" 
           name="intro_culture_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Danh mục Văn hóa Du lịch</label>
    <select class="form-control" name="intro_culture_id">
        <option value="">-- Chọn danh mục --</option>
        @php
            use App\Models\Terms;
            
            // Lấy tất cả terms với Taxonomy = 'tintuc'
            $terms = Terms::where('Taxonomy', 'tintuc')
                         ->orderBy('Name', 'asc')
                         ->get();
            
            // Lấy danh mục cha
            $parentTerms = $terms->where('Parent', 0);
            
            // Hàm đệ quy để hiển thị các danh mục con
            function renderTermsSelect($terms, $parentId = 0, $level = 0, $selected = '')
            {
                $children = $terms->where('Parent', $parentId);
                
                foreach ($children as $term) {
                    $padding = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
                    $isSelected = ($selected == $term->id) ? 'selected' : '';
                    
                    echo '<option value="' . $term->id . '" ' . $isSelected . '>' 
                         . $padding . $term->Name . '</option>';
                    
                    // Gọi đệ quy cho danh mục con
                    renderTermsSelect($terms, $term->id, $level + 1, $selected);
                }
            }
        @endphp
        
        @php
            $selectedCultureId = $data['culture_id'] ?? '';
            renderTermsSelect($terms, 0, 0, $selectedCultureId);
        @endphp
    </select>
    <small class="form-text text-muted">Chọn danh mục để hiển thị bài viết Văn hóa Du lịch</small>
</div>

<!-- Liên hệ -->
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Tiêu đề Liên hệ</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề Liên hệ" 
           value="{{ $data['contact_title'] ?? '' }}" 
           name="intro_contact_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Nút Xem thêm Liên hệ</label>
    <input type="text" class="form-control" 
           placeholder="Nhập văn bản nút Xem thêm" 
           value="{{ $data['contact_button'] ?? '' }}" 
           name="intro_contact_button" />
</div>
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Link Nút Xem thêm Liên hệ</label>
    <input type="text" class="form-control" 
           placeholder="Nhập Link Nút Xem thêm Liên hệ" 
           value="{{ $data['link_contact_button'] ?? '' }}" 
           name="intro_link_contact_button" />
</div>