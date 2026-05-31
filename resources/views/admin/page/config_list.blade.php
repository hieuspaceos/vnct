{{-- resources/views/admin/config/edit.blade.php --}}
@extends('admin.index')

@section('content')
<style>
    #password {
        -webkit-text-security: disc;
        color: #000;
    }
    .noselect {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    .tab-pane {
        background: #fff;
        padding: 1%;
    }
    .box-form {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }
    .box-form input[readonly] {
        background: #f8f9fa;
        flex: 1;
    }
    .del-imageDD {
        cursor: pointer;
        padding: 8px 12px;
        background: #dc3545;
        color: white;
        border-radius: 4px;
        border: none;
    }
    .img-anhdaidien {
        max-width: 200px;
        border: 1px solid #ddd;
        padding: 5px;
        margin-top: 10px;
    }
    .item_slide {
        position: relative;
        margin-bottom: 15px;
    }
    .xoaslide {
        position: absolute;
        right: 10px;
        top: 10px;
        cursor: pointer;
        background: #dc3545;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
    }
    .item_album {
        display: inline-block;
        position: relative;
        margin: 5px;
    }
    .del-album {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #dc3545;
        color: white;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    /* Style cho Menu Config mới */
.menu-list-container ul {
    list-style: none;
    padding-left: 0;
    margin-bottom: 0;
}
.menu-list-container ul ul {
    padding-left: 20px; /* Thụt lề cho menu con */
}
.menu-item {
    border: 1px solid #ddd;
    background-color: #f9f9f9;
    margin-bottom: 5px;
    padding: 0;
    border-radius: 4px;
    
}
.menu-item-content {
    display: flex;
		/*justify-content: space-between;*/
    align-items: center;
    gap: 10px;
    padding: 8px 10px;
    flex-grow: 1; /* Cho phép phần nội dung chiếm hết không gian còn lại */
}
.menu-config-wrapper .ui-sortable
{
    background: none;padding: 5px 5px 5px 30px; margin-bottom: 10px;    max-height: fit-content;
    overflow: auto;
}
.menu-handle {
    margin-right: 10px;
    color: #6c757d;
    cursor: grab;
}
.menu-actions {
    display: flex;
    gap: 5px;
}
.menu-actions .btn-link {
    padding: 0 5px;
    color: #007bff;
    text-decoration: none;
}
.menu-actions .btn-action-delete {
    color: #dc3545;
}
.menu-actions .btn-action-add {
    color: #28a745;
}

.menu-level-0 > .menu-item {
    font-weight: bold;
    background-color: #e9ecef; /* Màu nền khác cho mục cha */
}
.menu-toggle-icon {
    padding: 8px 5px;
    cursor: pointer;
    color: #6c757d;
}
.menu-item > ul {
    display: block; /* Mặc định hiển thị, sẽ dùng JS để ẩn/hiện */
    width: 100%;
    margin-top: 5px;
    padding-left: 0; /* Đã có padding ở ul cha */
}
.menu-item-collapsed > ul {
    display: none;
}
.btn.btn-primary
{
        left: 30px !important;
}
.form-control.type-image
{
        padding-left: 120px ;
}
</style>

<div class="content">
    <form method="POST" action="config/edit">
        @csrf
        <p class="thongbao text-danger fw-bold p-2">{{ session('message') }}</p>
        
        <div class="boxwhite">
            <div class="row">
                <div class="col-md-12">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-config-tab" data-toggle="tab" href="#nav-config" role="tab" aria-controls="nav-config" aria-selected="true">Config</a>
                            <a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="false">Home</a>
                            <a class="nav-item nav-link" id="nav-menu-tab" data-toggle="tab" href="#nav-menu" role="tab" aria-controls="nav-menu" aria-selected="false">Menu</a>
                            
                            <a class="nav-item nav-link" id="nav-presentation-tab" data-toggle="tab" href="#nav-presentation" role="tab" aria-controls="nav-presentation" aria-selected="true">Presentation</a>
                            <a class="nav-item nav-link" id="nav-introduccion-tab" data-toggle="tab" href="#nav-introduccion" role="tab" aria-controls="nav-introduccion" aria-selected="false">Introduccion</a>
                            <a class="nav-item nav-link" id="nav-Contact-tab" data-toggle="tab" href="#nav-Contact" role="tab" aria-controls="nav-Contact" aria-selected="false">Contact</a>
                            <a class="nav-item nav-link" id="nav-member-tab" data-toggle="tab" href="#nav-member" role="tab" aria-controls="nav-member" aria-selected="false">Member</a>
                            <a class="nav-item nav-link" id="nav-login-tab" data-toggle="tab" href="#nav-login" role="tab" aria-controls="nav-login" aria-selected="false">Login</a>
                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent">
                        {{-- Tab Config --}}
                        <div class="tab-pane fade show active" id="nav-config" role="tabpanel" aria-labelledby="nav-config-tab">
                            @foreach($config as $item)
                                {!! renderField($item, $allMenus_notpage ?? []) !!}
                            @endforeach
                            <div class="form-action mt-4">
                                <button type="submit" name="btn_save" class="btn btn-primary">
                                    <i class="fa fa-floppy-o"></i> Lưu
                                </button>
                            </div>
                        </div>

                        {{-- Tab Home --}}
                        <div class="tab-pane fade" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            @foreach($home as $item)
                                {!! renderField($item, $allMenus_notpage ?? []) !!}
                            @endforeach
                            <div class="form-action mt-4">
                                <button type="submit" name="btn_save" class="btn btn-primary">
                                    <i class="fa fa-floppy-o"></i> Lưu
                                </button>
                            </div>
                        </div>

                        {{-- Tab Menu --}}
                        <div class="tab-pane fade" id="nav-menu" role="tabpanel" aria-labelledby="nav-menu-tab">
                            @foreach($menu as $item)
                                {!! renderField($item, $allMenus ?? []) !!}
                            @endforeach
                            <div class="form-action mt-4">
                                <button type="submit" name="btn_save" class="btn btn-primary">
                                    <i class="fa fa-floppy-o"></i> Lưu
                                </button>
                            </div>
                        </div>
                        

                        <div class="tab-pane fade " id="nav-presentation" role="tabpanel" aria-labelledby="nav-presentation-tab">
                            @include("admin.page.config_presentation_tab")
                            <div class="form-action mt-4">
                                <button type="submit" value="ok" name="save_presentation" class="btn btn-primary">
                                    <i class="fa fa-floppy-o"></i> Lưu Presentation
                                </button>
                            </div>
                        </div>

                        {{-- Tab Introduccion --}}
                        <div class="tab-pane fade" id="nav-introduccion" role="tabpanel" aria-labelledby="nav-introduccion-tab">
                            @include("admin.page.config_introduccion")
                            <div class="form-action mt-4">
                                <button type="submit" value="ok" name="save_introduccion" class="btn btn-primary">
                                    <i class="fa fa-floppy-o"></i> Lưu Introduccion
                                </button>
                            </div>
                        </div>

                        {{-- Tab Contact --}}
                        <div class="tab-pane fade" id="nav-Contact" role="tabpanel" aria-labelledby="nav-Contact-tab">
                            @include("admin.page.config_contact")
                            <div class="form-action mt-4">
                                <button type="submit" value="ok" name="save_contact" class="btn btn-primary">
                                    <i class="fa fa-floppy-o"></i> Lưu Contact
                                </button>
                            </div>
                        </div>

                        {{-- Tab member --}}
                        <div class="tab-pane fade" id="nav-member" role="tabpanel" aria-labelledby="nav-member-tab">
                            @include("admin.page.config_member")
                            <div class="form-action mt-4">
                                <button type="submit" value="ok" name="save_member" class="btn btn-primary">
                                    <i class="fa fa-floppy-o"></i> Lưu member
                                </button>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-login" role="tabpanel" aria-labelledby="nav-login-tab">
                            @include("admin.page.config_auth")
                            <div class="form-action mt-4">
                                <button type="submit" value="ok" name="save_login" class="btn btn-primary">
                                    <i class="fa fa-floppy-o"></i> Lưu login
                                </button>
                            </div>
                        </div>

                    </div>

                    
                </div>
            </div>
        </div>

        <input type="hidden" name="textarea_array" class="textarea_array" value="{{ $textareaIds }}">
        <input type="hidden" name="checkbox_cate_array" class="checkbox_cate_array" value="{{ $checkboxCateIds }}">
    </form>
</div>

@php
// Helper function để render các loại field
function renderField($data, $allMenus = []) {
    switch($data['Type']) {
        case 'checkbox':
            return renderCheckbox($data);
        case 'text':
            return renderText($data);
        case 'pass':
            return renderPassword($data);
        case 'image':
            return renderImage($data);
        case 'textarea':
            return renderTextarea($data);
        case 'album':
            return renderAlbum($data);
        case 'slide':
            return renderSlide($data);
        case 'cate_combobox':
            return renderCateCombobox($data, $allMenus);
        case 'checkbox_cate':
            return renderCheckboxCate($data, $allMenus);
        case 'menu':
            return renderMenu($data, $allMenus);
        default:
            return '';
    }
}

function renderCheckbox($data) {
    $checked = $data['Value'] == 1 ? 'checked' : '';
    return <<<HTML
    <label class="mt-4">
        <i class="fa fa-check-circle-o"></i> {$data['TieuDe']}
    </label>
    <div class="form-check ml-1 mb-4">
        <input type="checkbox" {$checked} onchange="changeCheckbox({$data['id']})" class="form-check-input" id="exampleCheck{$data['id']}">
        <label class="form-check-label" for="exampleCheck{$data['id']}">Enable</label>
    </div>
    <input type="hidden" name="{$data['id']}" class="text{$data['id']}" value="{$data['Value']}">
HTML;
}

function renderText($data) {
    $value = htmlspecialchars($data['Value'] ?? '');
    return <<<HTML
    <label><i class="fa fa-check-circle-o"></i> {$data['TieuDe']}</label>
    <div class="form-group">
        <input type="text" placeholder="Nhập nội dung" name="{$data['id']}" class="text{$data['id']} form-control" value="{$value}">
    </div>
HTML;
}

function renderPassword($data) {
    $value = htmlspecialchars($data['Value'] ?? '');
    return <<<HTML
    <label><i class="fa fa-check-circle-o"></i> {$data['TieuDe']}</label>
    <div class="form-group">
        <input type="text" placeholder="Nhập nội dung" name="{$data['id']}" class="text{$data['id']} form-control" id="password" value="{$value}">
    </div>
HTML;
}

function renderImage($data) {
    $value = htmlspecialchars($data['Value'] ?? '');
    $imgSrc = $value ? env('APP_URL') . $value : '/template/admin/image/noimage.jpg';
    return <<<HTML
    <div class="form-group anhdaidien">
        <label><i class="fa fa-check-circle-o"></i> {$data['TieuDe']}</label>
        <div class="box-form">
            <input type="text" value="{$value}" placeholder="Chưa chọn hình" name="imagehinh{$data['id']}" id="file{$data['id']}" readonly class="form-control type-image">
            <button type="button" class="btn btn-primary" onclick="selectFileWithCKFinder_one('file{$data['id']}','file{$data['id']}','Images')">
                Chọn file
            </button>
            <button type="button" class="del-imageDD">
                <i class="fa fa-times"></i>
            </button>
        </div>
        <img class="img-anhdaidien file{$data['id']}" src="{$imgSrc}">
    </div>
HTML;
}

function renderTextarea($data) {
    $value = htmlspecialchars($data['Value'] ?? '');
    return <<<HTML
    <label><i class="fa fa-check-circle-o"></i> {$data['TieuDe']}</label>
    <textarea name="{$data['id']}" placeholder="Nhập nội dung" class="motangan form-control" rows="5">{$value}</textarea>
HTML;
}

function renderAlbum($data) {
    $value = htmlspecialchars($data['Value'] ?? '');
    return <<<HTML
    <div class="form-group anhdaidien">
        <label><i class="fa fa-check-circle-o"></i> {$data['TieuDe']}</label>
        <div class="box-form">
            <input type="text" value="{$value}" placeholder="Chưa chọn hình" name="{$data['id']}" id="file{$data['id']}" readonly class="form-control album-image">
            <button type="button" class="btn btn-primary" onclick="selectFileWithCKFinder('file{$data['id']}','file{$data['id']}','album')">
                Chọn file
            </button>
        </div>
        <div class="img-anhdaidien file{$data['id']} album_image">
            <div class="clear"></div>
        </div>
    </div>
HTML;
}

function renderSlide($data) {

    $array = json_decode($data['Value'] ?? '[]', true);

    // Mỗi slide gồm: URL – Hình – Content
    // => array: [url1, img1, content1, url2, img2, content2, ... ]

    $html = '<div class="form-group anhdaidien border p-3">';
    $html .= '<label><i class="fa fa-check-circle-o"></i> ' . $data['TieuDe'] . '</label>';
    $html .= '<div class="data_slide">';

    if (!empty($array)) {
        $slideNum = 0;

        for ($i = 0; $i < count($array); $i += 3) {
            $slideNum++;

            $url = $array[$i] ?? '';
            $image = $array[$i + 1] ?? '';
            $content = $array[$i + 2] ?? '';

            $imgSrc = $image ? env('APP_URL') . $image : '/template/admin/image/noimage.jpg';

            $html .= '<div class="item_slide border mt-2 p-3 slide' . $data['id'] . '-' . $slideNum . '">';

            if ($slideNum > 1) {
                $html .= '<a class="xoaslide" onclick="removeSlide(this,' . $slideNum . ')"><i class="fa fa-times"></i></a>';
            }

            // URL
            $html .= '<label><i class="fa fa-check-circle-o"></i> URL</label>';
            $html .= '<input type="text" placeholder="Link slide" name="slide' . $data['id'] . '[]" class="form-control mb-2" value="' . htmlspecialchars($url) . '">';

            // HÌnh
            $html .= '<label><i class="fa fa-check-circle-o"></i> Hình</label>';
            $html .= '<div class="box-form">';
            $html .= '<input type="text" value="' . htmlspecialchars($image) . '" placeholder="Chưa chọn hình" name="slide' . $data['id'] . '[]" id="file' . $data['id'] . '-' . $slideNum . '" readonly class="form-control type-image">';
            $html .= '<button type="button" class="btn btn-primary" onclick="selectFileWithCKFinder_one(\'file' . $data['id'] . '-' . $slideNum . '\',\'file' . $data['id'] . '-' . $slideNum . '\',\'Banner\')">Chọn file</button>';
            $html .= '<button type="button" class="del-imageDD"><i class="fa fa-times"></i></button>';
            $html .= '</div>';
            $html .= '<img class="img-anhdaidien file' . $data['id'] . '-' . $slideNum . '" src="' . $imgSrc . '">';

            // CONTENT
            $contentId = "content{$data['id']}-$slideNum";
            $html .= '<div class="mt-2"><i class="fa fa-check-circle-o"></i> Content</div>';
            $html .= '<textarea id="' . $contentId . '" name="slide' . $data['id'] . '[]" class="form-control" rows="4">' . htmlspecialchars($content) . '</textarea>';

            $html .= "<script>
                setTimeout(function(){
                    if (CKEDITOR.instances['$contentId']) CKEDITOR.instances['$contentId'].destroy();
                    CKEDITOR.replace('$contentId', {
                        uiColor: '#ebf2f6',
                        language: 'vi',
                        filebrowserImageBrowseUrl: '" . route('ckfinder_browser') . "?resourceType=Images',
                        filebrowserImageUploadUrl: '" . route('ckfinder_connector') . "?command=QuickUpload&resourceType=Images'
                    });
                }, 200);
            </script>";

            $html .= '</div>';
        }
    } else {

        $html .= '<div class="item_slide border mt-2 p-3 slide' . $data['id'] . '-1">';

        // URL
        $html .= '<label><i class="fa fa-check-circle-o"></i> URL</label>';
        $html .= '<input type="text" placeholder="Link slide" name="slide' . $data['id'] . '[]" class="form-control mb-2">';

        // HÌnh
        $html .= '<label><i class="fa fa-check-circle-o"></i> Hình</label>';
        $html .= '<div class="box-form">';
        $html .= '<input type="text" placeholder="Chưa chọn hình" name="slide' . $data['id'] . '[]" id="file' . $data['id'] . '-1" readonly class="form-control type-image">';
        $html .= '<button type="button" class="btn btn-primary" onclick="selectFileWithCKFinder_one(\'file' . $data['id'] . '-1\',\'file' . $data['id'] . '-1\',\'Banner\')">Chọn file</button>';
        $html .= '<button type="button" class="del-imageDD"><i class="fa fa-times"></i></button>';
        $html .= '</div>';
        $html .= '<img class="img-anhdaidien file' . $data['id'] . '-1" src="/template/admin/image/noimage.jpg">';

        // CONTENT
        $contentId = "content{$data['id']}-1";
        $html .= '<div class="mt-2"><i class="fa fa-check-circle-o"></i> Content</div>';
        $html .= '<textarea id="' . $contentId . '" name="slide' . $data['id'] . '[]" class="form-control" rows="4"></textarea>';

        $html .= "<script>
            setTimeout(function(){
                if (CKEDITOR.instances['$contentId']) CKEDITOR.instances['$contentId'].destroy();
                CKEDITOR.replace('$contentId', {
                    uiColor: '#ebf2f6',
                    language: 'vi',
                    filebrowserImageBrowseUrl: '" . route('ckfinder_browser') . "?resourceType=Images',
                    filebrowserImageUploadUrl: '" . route('ckfinder_connector') . "?command=QuickUpload&resourceType=Images'
                });
            }, 200);
        </script>";

        $html .= '</div>';
    }

    $html .= '</div>';
    $html .= '<button type="button" class="btn btn-primary mt-2" onclick="themSlide(this,' . $data['id'] . ')">Thêm slide</button>';
    $html .= '</div>';

    return $html;
}


function renderCateCombobox($data, $allMenus) {
    $html = '<label><i class="fa fa-check-circle-o"></i> ' . $data['TieuDe'] . '</label>';
    $html .= '<div class="form-group"><select class="form-control" name="' . $data['id'] . '">';
    
    foreach ($allMenus as $menu) {
        $selected = $data['Value'] == $menu['id'] ? 'selected' : '';
        $html .= '<option ' . $selected . ' value="' . $menu['id'] . '">' . htmlspecialchars($menu['Name']) . '</option>';
    }
    
    $html .= '</select></div>';
    return $html;
}

function renderCheckboxCate($data, $allMenus) {
    $values = explode(',', $data['Value'] ?? '');
    $html = '<label><i class="fa fa-check-circle-o"></i> ' . $data['TieuDe'] . '</label>';
    $html .= '<div id="sortable' . $data['id'] . '" class="ui-sortable">';
    
    foreach ($allMenus as $menu) {
        $checked = in_array($menu['id'], $values) ? 'checked' : '';
        $html .= '<div class="form-check ui-state-default">';
        $html .= '<input name="arraycheckbox' . $data['id'] . '[]" ' . $checked . ' type="checkbox" class="form-check-input" id="' . $data['id'] . $menu['id'] . '" value="' . $menu['id'] . '">';
        $html .= '<i class="fas fa-arrows-alt-v"></i>';
        $html .= '<label class="form-check-label" for="' . $data['id'] . $menu['id'] . '">' . htmlspecialchars($menu['Name']) . '</label>';
        $html .= '</div>';
    }
    
    $html .= '</div>';
    return $html;
}

function renderMenu($data, $allMenus)
{
   // dd($data);
    // Decode giá trị JSON an toàn
    $menuData = json_decode($data['Value'] ?? '[]', true);

    $html = '<div class="menu-config-wrapper">';
    $html .= '<button type="button" class="btn btn-danger mb-3" onclick="openAddNewMenuModal(null, ' . (int)$data['id'] . ')">';
    $html .= '<i class="fa fa-plus"></i> Thêm menu mới';
    $html .= '</button>';

    $html .= '<div class="menu-list-container" id="menu-list-' . (int)$data['id'] . '">';

    // Render danh sách menu
    $html .= renderMenuItems($menuData, (int)$data['id']);

    $html .= '</div>';

    // Hidden input lưu cấu trúc menu
    $html .= '<input type="hidden" name="menu' . (int)$data['id'] . '" id="menuchinh-' . (int)$data['id'] . '" ';
    $html .= 'class="menuchinh" value="' . e($data['Value'] ?? '[]') . '">';

    $html .= '</div>';

    return $html;
}

/**
 * Hàm đệ quy render menu con
 */
function renderMenuItems($items, $configId, $level = 0)
{
    if (empty($items)) return '';

    $html = '<ul class="menu-level-' . $level . '">';

    foreach ($items as $item) {
        $name = e($item['name'] ?? 'Mục mới');
        $itemId = $item['id'] ?? ('temp-' . uniqid());
        $itemJson = htmlspecialchars(json_encode($item, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8');

        // Có con thì hiển thị icon toggle
        $hasChildren = !empty($item['children']);
        $toggleIcon = $hasChildren
            ? '<span class="menu-toggle-icon" onclick="toggleSubMenu(this)"><i class="fas fa-minus"></i></span>'
            : '';

        $html .= '<li class="menu-item menu-item-level-' . $level . '" 
                    data-menu-id="' . e($itemId) . '" 
                    data-menu-data="' . $itemJson . '" 
                    data-config-id="' . (int)$configId . '">';

        
        $html .= '<div class="menu-item-content">';
        $html .= $toggleIcon;
        $html .= '<i class="fas fa-grip-vertical menu-handle"></i>';
        $html .= '<span>' . $name . '</span>';

        // Action buttons
        $html .= '<div class="menu-actions">';
        $html .= '<button type="button" class="btn btn-link btn-action-add" onclick="openAddNewMenuModal(this, ' . (int)$configId . ', true)"><i class="fa fa-plus"></i></button>';
        $html .= '<button type="button" class="btn btn-link btn-action-edit" onclick="openEditMenuModal(this)"><i class="fa fa-pencil-alt"></i></button>';
        $html .= '<button type="button" class="btn btn-link btn-action-delete" onclick="deleteMenuItem(this)"><i class="fa fa-trash"></i></button>';
        $html .= '</div>'; // end .menu-actions
        $html .= '</div>'; // end .menu-item-content

        // Render children (nếu có)
        if ($hasChildren) {
            $html .= renderMenuItems($item['children'], $configId, $level + 1);
        }

        $html .= '</li>';
    }

    $html .= '</ul>';

    return $html;
}

@endphp
@endsection
<div class="modal fade" id="menuModal" tabindex="-1" role="dialog" aria-labelledby="menuModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="menuModalLabel">Chỉnh Sửa Liên Kết</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="menuForm">
          <div class="form-group">
            <label for="linkName">Tên liên kết</label>
            <input type="text" class="form-control" id="linkName" required>
            <small class="form-text text-muted">chỉ thêm image cho danh mục cha và danh mục sản phẩm không cần thêm cũng được</small>
          </div>
          <div class="form-group">
            <label for="linkIcon">Icon (CSS Class)</label>
            <input type="text" class="form-control" id="linkIcon">
          </div>
          
          <div class="form-group">
            <label for="linkTo">Liên kết đến</label>
            <select class="form-control" id="linkTo">
              <option value="home">Trang chủ</option>
              <option value="news_category">Danh mục tin tức</option>
              <option value="news_post">Tin tức</option>
              <option value="page">Trang</option>
              <option value="custom_link">Custom Link</option>
            </select>
          </div>
          
          <div id="dynamicLinkTarget"></div>
          
          <input type="hidden" id="currentMenuItemData">
          <input type="hidden" id="currentConfigId">
          <input type="hidden" id="isSubMenu">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-primary" id="saveMenuBtn">Lưu</button>
      </div>
    </div>
  </div>
</div>
@section('js')
<script>
// Cần giả định các route sau đã tồn tại trong Laravel
const AJAX_ROUTES = {
    'news_category': 'api/categories', // Giả sử route để lấy danh mục tin tức (dùng Select2)
    'news_post': 'api/news',     // Giả sử route để lấy tin tức (dùng Select2)
    'page': 'api/pages',               // Giả sử route để lấy trang (dùng Select2)
};

// Hàm đệ quy để serialize menu item thành cấu trúc mong muốn
function serializeMenu(item) {
    let serialized = {
        id: item.id || Date.now(),
        name: item.name || 'Mục mới',
        link_type: item.link_type || 'home',
        link_value: item.link_value || '',
        icon: item.icon || '',
        children: []
    };

    if (item.children) {
        item.children.forEach(child => {
            serialized.children.push(serializeMenu(child));
        });
    }

    return serialized;
}

/**
 * Khởi tạo Sortable (sắp xếp menu)
 */
function initNestable() {
    $('.menu-list-container ul').each(function() {
        if (!$(this).data('ui-sortable')) {
            $(this).sortable({
                handle: '.menu-handle',
                connectWith: '.menu-list-container ul',
                placeholder: 'menu-item-placeholder',
                forcePlaceholderSize: true,
                opacity: 0.8,
                stop: function(event, ui) {
                    const configId = $(ui.item)
                        .closest('.menu-config-wrapper')
                        .find('.menuchinh')
                        .attr('id')
                        .replace('menuchinh-', '');
                    updateMenuStructure(configId);
                }
            });
        }
    });
}

function updateMenuStructure(configId) {
    const $rootUl = $('#menu-list-' + configId + ' > ul');
    function getMenuData($ul) {
        let data = [];
        $ul.children('li').each(function() {
            const itemData = JSON.parse($(this).attr('data-menu-data'));
            let obj = {
                id: itemData.id,
                name: $(this).find('> .menu-item-content > span').text(),
                link_type: itemData.link_type,
                link_value: itemData.link_value,
                icon: itemData.icon,
                children: []
            };
            const $childUl = $(this).children('ul');
            if ($childUl.length) {
                obj.children = getMenuData($childUl);
            }
            data.push(obj);
        });
        return data;
    }
    const newData = getMenuData($rootUl);
    $('#menuchinh-' + configId).val(JSON.stringify(newData));
}

// Xử lý collapse/expand menu con
function toggleSubMenu(btn) {
    const $li = $(btn).closest('li');
    $li.toggleClass('menu-item-collapsed');
    $(btn).find('i').toggleClass('fa-minus fa-plus');
}

// Xóa menu item
function deleteMenuItem(btn) {
    if (!confirm('Bạn có chắc muốn xóa mục menu này và các mục con?')) return;
    const $li = $(btn).closest('li');
    const configId = $li.data('config-id');
    $li.remove();
    updateMenuStructure(configId);
}

// Mở modal thêm menu mới (mục cha) hoặc thêm mục con
function openAddNewMenuModal(btn, configId, isSub = false) {
    $('#menuModalLabel').text(isSub ? 'Thêm mục con' : 'Thêm menu mới');
    $('#menuForm')[0].reset();
    $('#linkTo').val('home').trigger('change');
    $('#currentConfigId').val(configId);
    $('#isSubMenu').val(isSub);
    $('#currentMenuItemData').val('');

    // 🟢 Ghi lại parentId chính xác nếu là thêm menu con
    if (isSub && btn) {
        const parentLi = $(btn).closest('li');
        const parentId = parentLi.attr('data-menu-id');
        $('#menuModal').attr('data-parent-id', parentId);
    } else {
        $('#menuModal').removeAttr('data-parent-id');
    }

    $('#menuModal').removeAttr('data-edit-id'); // đảm bảo không ghi đè khi edit
    $('#menuModal').modal('show');
}

// Mở modal chỉnh sửa menu
function openEditMenuModal(btn) {
    const $li = $(btn).closest('li');
    const data = JSON.parse($li.attr('data-menu-data'));
    const configId = $li.data('config-id');

    $('#menuModalLabel').text('Chỉnh sửa menu');
    $('#linkName').val(data.name);
    $('#linkIcon').val(data.icon);
    $('#linkTo').val(data.link_type || 'home');
    $('#currentConfigId').val(configId);
    $('#currentMenuItemData').val(JSON.stringify(data));

    // Xác định menu con hay menu cha
    const parentLi = $li.parent().closest('li');
    if (parentLi.length) {
        $('#isSubMenu').val(true);
        $('#menuModal').attr('data-parent-id', parentLi.attr('data-menu-id'));
    } else {
        $('#isSubMenu').val(false);
        $('#menuModal').removeAttr('data-parent-id');
    }

    // ✅ Load input/select tương ứng với giá trị cũ
    loadDynamicLinkTarget(data.link_type, data.link_value);

    $('#menuModal').attr('data-edit-id', data.id);
    $('#menuModal').modal('show');
}


// Xử lý hiển thị Dynamic Link Target
function loadDynamicLinkTarget(linkType, currentValue = null) {
		console.log(linkType,currentValue);
    const $dynamicTarget = $('#dynamicLinkTarget');
    $dynamicTarget.empty();

    if (linkType === 'home') return;

    if (linkType === 'custom_link') {
        $dynamicTarget.html(`
            <div class="form-group">
                <label>URL Tùy chỉnh</label>
                <input type="text" id="customLinkInput" class="form-control" value="${currentValue || ''}">
            </div>
        `);
    } else if (['news_category','news_post','page'].includes(linkType)) {
        const label = linkType.replace('_', ' ');
        $dynamicTarget.html(`
            <div class="form-group">
                <label>Chọn ${label}</label>
                <select class="form-control select2-dynamic" id="selectLinkData" style="width:100%;"></select>
            </div>
        `);

        const $select = $('#selectLinkData');

        // Khởi tạo Select2 với AJAX
        $select.select2({
	        dropdownParent: $('#menuModal'),
	        placeholder: `Chọn ${label}`,
	        allowClear: true,
	        ajax: {
	            url: AJAX_ROUTES[linkType],
	            dataType: 'json',
	            delay: 250,
	            data: params => ({ q: params.term }),
	            processResults: data => ({ results: data.results || [] })
	        }
	    });

        if (currentValue) {
	        // Tạo option tạm để Select2 hiển thị ngay giá trị cũ
	        const tempOption = new Option('Đang tải...', currentValue, true, true);
	        $select.append(tempOption).trigger('change');

	        // Fetch dữ liệu thật để show text chính xác
	        $.ajax({
	            url: AJAX_ROUTES[linkType],
	            data: { q: '' }, // hoặc nếu API hỗ trợ id, có thể dùng data: {id: currentValue}
	            dataType: 'json'
	        }).then(res => {
	            const match = res.results.find(item => item.id == currentValue);
	            if (match) {
	                const option = new Option(match.text, match.id, true, true);
	                $select.empty().append(option).trigger('change');
	            }
	        });
	    }
    }
}

// Xử lý sự kiện khi click Lưu
$('#saveMenuBtn').click(function() {
    const configId = $('#currentConfigId').val();
    const isSub = $('#isSubMenu').val() === 'true';
    const editId = $('#menuModal').attr('data-edit-id');
    const parentId = $('#menuModal').attr('data-parent-id');

    // Lấy link value dựa trên loại
    const linkType = $('#linkTo').val();
    let linkValue = '';
    if (linkType === 'custom_link') {
        linkValue = $('#customLinkInput').val();
    } else if (['news_category','news_post','page'].includes(linkType)) {
        linkValue = $('#selectLinkData').val();
    }

    // Tạo object menu mới
    const newItem = {
        id: editId || 'temp-' + Date.now(),
        name: $('#linkName').val() || 'Mục mới',
        link_type: linkType,
        link_value: linkValue,
        icon: $('#linkIcon').val() || '',
        children: []
    };

    // Nếu đang sửa menu
    if (editId) {
        const $li = $(`#menu-list-${configId} li[data-menu-id='${editId}']`);
        if ($li.length) {
            // Lấy dữ liệu cũ
            const oldData = JSON.parse($li.attr('data-menu-data') || '{}');
            
            // Tạo object mới nhưng GIỮ LẠI children cũ
            const updatedItem = {
                ...oldData,  // Giữ lại tất cả dữ liệu cũ (bao gồm children)
                name: $('#linkName').val() || 'Mục mới',
                link_type: linkType,
                link_value: linkValue,
                icon: $('#linkIcon').val() || '',
                // Không ghi đè children, giữ nguyên children cũ
            };
            
            // Cập nhật data attribute
            $li.attr('data-menu-data', JSON.stringify(updatedItem));
            
            // Cập nhật hiển thị
            $li.find('> .menu-item-content > span:not(.menu-toggle-icon)').text(updatedItem.name);
            
            // Xử lý icon
            const $icon = $li.find('> .menu-item-content > i:not(.menu-handle):not(.fa-grip-vertical)');
            if (updatedItem.icon) {
                if ($icon.length) {
                    $icon.attr('class', updatedItem.icon);
                } else {
                    $li.find('> .menu-item-content').prepend(`<i class="${updatedItem.icon}"></i>`);
                }
            } else {
                $icon.remove();
            }
        }
    } else {
        // Tạo li mới
        const level = isSub ? $(`#menu-list-${configId} li[data-menu-id='${parentId}']`).closest('ul').data('level') + 1 || 1 : 0;
        const $li = $(`
            <li class="menu-item menu-item-level-${level}"
                data-menu-id="${newItem.id}"
                data-config-id="${configId}"
                data-menu-data='${JSON.stringify(newItem)}'>
                <div class="menu-item-content">
                    <i class="fas fa-grip-vertical menu-handle"></i>
                    <span>${newItem.name}</span>
                    <div class="menu-actions">
                        <button type="button" class="btn btn-link btn-action-add"
                            onclick="openAddNewMenuModal(this, ${configId}, true)">
                            <i class="fa fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-link btn-action-edit"
                            onclick="openEditMenuModal(this)">
                            <i class="fa fa-pencil-alt"></i>
                        </button>
                        <button type="button" class="btn btn-link btn-action-delete"
                            onclick="deleteMenuItem(this)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </li>
        `);

        // Thêm vào đúng vị trí
        if (isSub && parentId) {
            const $parent = $(`#menu-list-${configId} li[data-menu-id='${parentId}']`);
            if ($parent.length) {
                let $ul = $parent.children('ul');
                if ($ul.length === 0) {
                    $ul = $('<ul class="menu-level-' + (level + 1) + '"></ul>');
                    $parent.find('> .menu-item-content').prepend('<span class="menu-toggle-icon" onclick="toggleSubMenu(this)"><i class="fas fa-minus"></i></span>');
                    $parent.append($ul);
                }
                $ul.append($li);
            }
        } else {
            // Thêm menu cha ngoài cùng
            let $rootUl = $(`#menu-list-${configId} > ul.menu-level-0`);
            if ($rootUl.length === 0) {
                $rootUl = $('<ul class="menu-level-0"></ul>');
                $(`#menu-list-${configId}`).append($rootUl);
            }
            $rootUl.append($li);
        }
    }

    // Cập nhật input ẩn và sortable
    updateMenuStructure(configId);
    initNestable();

    // Đóng modal
    $('#menuModal').modal('hide');
    $('#menuModal').removeAttr('data-edit-id data-parent-id');
});


// Sự kiện thay đổi loại liên kết
$('#linkTo').on('change', function(event, currentValue = null) {
    const type = $(this).val();
    loadDynamicLinkTarget(type, currentValue);
});


// Document ready
$(function() {
    // Khởi tạo sortable cho menu (Nestable)
    initNestable();

    // Khởi tạo CKEditor và sortable cho checkbox category (như cũ)
    // ... [GIỮ NGUYÊN CODE KHỞI TẠO CKEDITOR VÀ SORTABLE Ở ĐÂY] ...
    
    // Khởi tạo CKEditor
    const textareaArray = $(".textarea_array").val().split(",").filter(Boolean);
    textareaArray.forEach(id => {
        CKEDITOR.replace(id, {
            uiColor: '#ebf2f6',
            language: 'vi',
            filebrowserImageBrowseUrl: '{{ route('ckfinder_browser') }}?resourceType=Images',
            filebrowserImageUploadUrl: '{{ route('ckfinder_connector') }}?command=QuickUpload&resourceType=Images'
        });
    });
    
    // Khởi tạo sortable cho checkbox category
    const checkboxCateArray = $(".checkbox_cate_array").val().split(",").filter(Boolean);
    checkboxCateArray.forEach(id => {
        $("#sortable" + id).sortable();
        $("#sortable" + id).disableSelection();
    });
    
    // Xử lý album images (như cũ)
    initAlbumImages();
    // Xử lý single images (như cũ)
    initTypeImages();
    
    // Xóa ảnh đại diện (như cũ)
    $(".del-imageDD").click(function() {
        $(this).parent().find("input").val('');
        $(this).parent().next('img').attr('src', '/template/admin/image/noimage.jpg');
    });
});

// Hàm escape HTML cho JSON string (để lưu vào data-attribute)
function htmlspecialchars(str) {
    if (typeof str == "string") {
        str = str.replace(/&/g, "&amp;");
        str = str.replace(/"/g, "&quot;");
        str = str.replace(/'/g, "&#039;");
        str = str.replace(/</g, "&lt;");
        str = str.replace(/>/g, "&gt;");
    }
    return str;
}

// ... [GIỮ NGUYÊN CÁC HÀM KHÁC NHƯ changeCheckbox, initAlbumImages, initTypeImages, themSlide, removeSlide, CKFinder functions] ...
// Lưu ý: Các hàm liên quan đến nestable cũ (themMenuLanDau, buttonDelete, themmenu, updateOutput) đã bị thay thế hoặc không còn cần thiết với cấu trúc mới.

// Khởi tạo album images
function initAlbumImages() {
    $(".album-image").each(function() {
        const url = $(this).val();
        if (!url) return;
        
        const urls = url.split(",");
        let html = "";
        
        urls.forEach(imgUrl => {
            html += `<div class='item_album'>
                <img src='${imgUrl}' width='100' height='100'>
                <a class='del-album' data='${imgUrl}'><i class='fa fa-times'></i></a>
            </div>`;
        });
        
        $(this).parent().parent().find(".album_image").prepend(html);
        
        // Event xóa album
        $(".del-album").off('click').on('click', function() {
            const $input = $(this).closest('.anhdaidien').find(".album-image");
            let currentUrls = $input.val().split(",");
            const removeUrl = $(this).attr("data");
            
            currentUrls = currentUrls.filter(u => u !== removeUrl);
            $input.val(currentUrls.join(","));
            $(this).parent().remove();
        });
    });
}

// Khởi tạo type images
function initTypeImages() {
    $(".type-image").each(function() {
        const url = $(this).val();
        if (url) {
            $(this).closest('.anhdaidien').find(".img-anhdaidien").attr("src", "{{ env('APP_URL') }}" + url);
        }
    });
}

// Thêm slide
function themSlide(btn, id) {
    const $dataSlide = $(btn).parent().find('.data_slide');
    const soluong = $dataSlide.find('> div').length + 1;

    const contentId = `content${id}-${soluong}`;

    const html = `
        <div class="item_slide border p-3 mt-2 slide${id}-${soluong}">
            <a class="xoaslide" onclick="removeSlide(this, ${soluong})"><i class="fa fa-times"></i></a>

            <label><i class="fa fa-check-circle-o"></i> URL</label>
            <input type="text" placeholder="Link slide" name="slide${id}[]" class="form-control mb-2">

            <label><i class="fa fa-check-circle-o"></i> Hình</label>
            <div class="box-form">
                <input type="text" placeholder="Chưa chọn hình" name="slide${id}[]" id="file${id}-${soluong}" readonly class="form-control type-image">
                <button type="button" class="btn btn-primary" onclick="selectFileWithCKFinder_one('file${id}-${soluong}','file${id}-${soluong}','Banner')">Chọn file</button>
                <button type="button" class="del-imageDD"><i class="fa fa-times"></i></button>
            </div>

            <img class="img-anhdaidien file${id}-${soluong}" src="/template/admin/image/noimage.jpg">

            <div class="mt-2"><i class="fa fa-check-circle-o"></i> Content</div>
            <textarea id="${contentId}" name="slide${id}[]" class="form-control" rows="4"></textarea>
        </div>
    `;

    $dataSlide.append(html);

    // Gọi CKEditor sau khi thêm DOM
    setTimeout(() => {
        if (CKEDITOR.instances[contentId]) CKEDITOR.instances[contentId].destroy();
        CKEDITOR.replace(contentId, {
            uiColor: '#ebf2f6',
            language: 'vi',
            filebrowserImageBrowseUrl: '{{ route('ckfinder_browser') }}?resourceType=Images',

            filebrowserImageUploadUrl: '{{ route('ckfinder_connector') }}?command=QuickUpload&resourceType=Images'
        });
    }, 200);
}


// Xóa slide
function removeSlide(btn, id) {
    const $parent = $(btn).parent().parent();
    const total = $parent.find('> div').length;
    
    if (total === id) {
        if (confirm("Bạn thật sự muốn xóa?")) {
            $(btn).parent().remove();
        }
    } else {
        alert("Xóa slide phía dưới trước nhé");
    }
}

// CKFinder - Single file
function selectFileWithCKFinder_one(elementId, callback, startupPath) {
    CKFinder.popup({
        chooseFiles: true,
        width: 800,
        height: 600,
        resourceType: startupPath,
        onInit: function(finder) {
            finder.on('files:choose', function(evt) {
                const file = evt.data.files.first();
                const url = file.getUrl().replace("{{ env('APP_URL') }}", "");
                
                document.getElementById(elementId).value = url;
                $("." + callback).attr('src', url);
            });
        }
    });
}

// CKFinder - Multiple files
function selectFileWithCKFinder(elementId, callback, startupPath) {
    CKFinder.popup({
        chooseFiles: true,
        width: 800,
        height: 600,
        selectMultiple: true,
        resourceType: startupPath,
        onInit: function(finder) {
            finder.on('files:choose', function(evt) {
                let html = "";
                let urls = [];
                
                evt.data.files.forEach(function(file) {
                    const url = file.get('url').replace("{{ env('APP_URL') }}", "");
                    urls.push(url);
                    html += `<div class='item_album'>
                        <img src='${url}' width='100' height='100'>
                        <a class='del-album' data='${url}'><i class='fa fa-times'></i></a>
                    </div>`;
                });
                
                $("." + callback).prepend(html);
                $("#" + elementId).val(urls.join(","));
                
                // Re-bind delete event
                $(".del-album").off('click').on('click', function() {
                    const $input = $("#" + elementId);
                    let currentUrls = $input.val().split(",");
                    const removeUrl = $(this).attr("data");
                    
                    currentUrls = currentUrls.filter(u => u !== removeUrl);
                    $input.val(currentUrls.join(","));
                    $(this).parent().remove();
                });
            });
        }
    });
}

{{-- // Khởi tạo menu
const menuChinh = JSON.parse($(".menuchinh").val() || '[]');
let chuoi = "";
menuChinh.forEach(item => {
    chuoi += themMenuLanDau(item);
});
$(".nestable > .dd-list").append(chuoi); --}}

// Change checkbox
function changeCheckbox(id) {
    const value = $('#exampleCheck' + id).is(":checked") ? 1 : 0;
    $(".text" + id).val(value);
}

// Thêm menu lần đầu
{{-- function themMenuLanDau(e, str = "") {
    str += `<li class="dd-item" data-id="${e.id}" data-name="${e.name}" data-slug="${e.slug}" data-taxonomy="${e.taxonomy}" data-image="${e.image}">`;
    str += `<div class="dd-handle">${e.name}</div>`;
    str += `<span onclick="buttonDelete(this)" class="button-delete btn btn-default btn-xs pull-right">`;
    str += `<i class="fas fa-times-circle"></i></span>`;
    
    if (e.children) {
        str += '<ol class="dd-list">';
        e.children.forEach(child => {
            str += themMenuLanDau(child);
        });
        str += '</ol>';
    }
    
    str += '</li>';
    return str;
} --}}

// Xóa menu item
{{-- function buttonDelete(e) {
    const $parent = $(e).parent();
    const data = {
        id: $parent.attr('data-id'),
        taxonomy: $parent.attr('data-taxonomy'),
        name: $parent.attr('data-name'),
        slug: $parent.attr('data-slug'),
        image: $parent.attr('data-image')
    };
    
    $parent.remove();
    updateOutput();
} --}}

// Thêm menu
{{-- function themmenu(e) {
    const $el = $(e);
    const data = {
        id: $el.attr('data-id'),
        taxonomy: $el.attr('data-taxonomy'),
        name: $el.attr('data-name'),
        slug: $el.attr('data-slug'),
        image: $el.attr('data-image')
    };
    
    let str = `<li class="dd-item" data-id="${data.id}" data-name="${data.name}" data-slug="${data.slug}" data-taxonomy="${data.taxonomy}" data-image="${data.image}">`;
    str += `<div class="dd-handle">${data.name}</div>`;
    str += `<span onclick="buttonDelete(this)" class="button-delete btn btn-default btn-xs pull-right">`;
    str += `<i class="fas fa-times-circle"></i></span></li>`;
    
    $(".nestable > .dd-list").append(str);
    updateOutput();
}

function updateOutput() {
    $(".menuchinh").val(JSON.stringify($('.dd.nestable').nestable('serialize')));
}
 --}}
// Document ready
$(function() {
    // Khởi tạo nestable
   // $('.dd.nestable').nestable({ maxDepth: 5 }).on('change', updateOutput);
    
    // Khởi tạo CKEditor cho textarea
    const textareaArray = $(".textarea_array").val().split(",").filter(Boolean);
    textareaArray.forEach(id => {
        CKEDITOR.replace(id, {
            uiColor: '#ebf2f6',
            language: 'vi',
            filebrowserImageBrowseUrl: '{{ route('ckfinder_browser') }}?resourceType=Images',
            filebrowserImageUploadUrl: '{{ route('ckfinder_connector') }}?command=QuickUpload&resourceType=Images'
        });
    });
    
    // Khởi tạo sortable cho checkbox category
    const checkboxCateArray = $(".checkbox_cate_array").val().split(",").filter(Boolean);
    checkboxCateArray.forEach(id => {
        $("#sortable" + id).sortable();
        $("#sortable" + id).disableSelection();
    });
    
    // Xử lý album images
    initAlbumImages();
    
    // Xử lý single images
    initTypeImages();
    
    // Xóa ảnh đại diện
    $(".del-imageDD").click(function() {
        $(this).parent().find("input").val('');
        $(this).parent().next('img').attr('src', '/template/admin/image/noimage.jpg');
    });
});

// Khởi tạo album images
function initAlbumImages() {
    $(".album-image").each(function() {
        const url = $(this).val();
        if (!url) return;
        
        const urls = url.split(",");
        let html = "";
        
        urls.forEach(imgUrl => {
            html += `<div class='item_album'>
                <img src='${imgUrl}' width='100' height='100'>
                <a class='del-album' data='${imgUrl}'><i class='fa fa-times'></i></a>
            </div>`;
        });
        
        $(this).parent().parent().find(".album_image").prepend(html);
        
        // Event xóa album
        $(".del-album").click(function() {
            const $input = $(this).closest('.anhdaidien').find(".album-image");
            let currentUrls = $input.val().split(",");
            const removeUrl = $(this).attr("data");
            
            currentUrls = currentUrls.filter(u => u !== removeUrl);
            $input.val(currentUrls.join(","));
            $(this).parent().remove();
        });
    });
}

// Khởi tạo type images
function initTypeImages() {
    $(".type-image").each(function() {
        const url = $(this).val();
        if (url) {
            $(this).closest('.anhdaidien').find(".img-anhdaidien").attr("src", "{{ env('APP_URL') }}" + url);
        }
    });
}

// Thêm slide
{{-- function themSlide(btn, id) {
    const $dataSlide = $(btn).parent().find('.data_slide');
    const soluong = $dataSlide.find('> div').length + 1;
    
    const html = `
        <div class="item_slide border p-3 mt-2 slide${id}-${soluong}">
            <a class="xoaslide" onclick="removeSlide(this, ${soluong})"><i class="fa fa-times"></i></a>
            <label><i class="fa fa-check-circle-o"></i> URL</label>
            <input type="text" placeholder="Link slide" name="slide${id}[]" class="form-control mb-2">
            <label><i class="fa fa-check-circle-o"></i> Hình</label>
            <div class="box-form">
                <input type="text" placeholder="Chưa chọn hình" name="slide${id}[]" id="file${id}-${soluong}" readonly class="form-control type-image">
                <button type="button" class="btn btn-primary" onclick="selectFileWithCKFinder_one('file${id}-${soluong}','file${id}-${soluong}','Banner')">Chọn file</button>
                <button type="button" class="del-imageDD"><i class="fa fa-times"></i></button>
            </div>
            <img class="img-anhdaidien file${id}-${soluong}" src="/template/admin/image/noimage.jpg">
        </div>
    `;
    
    $dataSlide.append(html);
}

// Xóa slide
function removeSlide(btn, id) {
    const $parent = $(btn).parent().parent();
    const total = $parent.find('> div').length;
    
    if (total === id) {
        if (confirm("Bạn thật sự muốn xóa?")) {
            $(btn).parent().remove();
        }
    } else {
        alert("Xóa slide phía dưới trước nhé");
    }
}
 --}}
// CKFinder - Single file
function selectFileWithCKFinder_one(elementId, callback, startupPath) {
    CKFinder.popup({
        chooseFiles: true,
        width: 800,
        height: 600,
        resourceType: startupPath,
        onInit: function(finder) {
            finder.on('files:choose', function(evt) {
                const file = evt.data.files.first();
                const url = file.getUrl().replace("{{ env('APP_URL') }}", "");
                
                document.getElementById(elementId).value = url;
                $("." + callback).attr('src', url);
            });
        }
    });
}

// CKFinder - Multiple files
function selectFileWithCKFinder(elementId, callback, startupPath) {
    CKFinder.popup({
        chooseFiles: true,
        width: 800,
        height: 600,
        selectMultiple: true,
        resourceType: startupPath,
        onInit: function(finder) {
            finder.on('files:choose', function(evt) {
                let html = "";
                let urls = [];
                
                evt.data.files.forEach(function(file) {
                    const url = file.get('url').replace("{{ env('APP_URL') }}", "");
                    urls.push(url);
                    html += `<div class='item_album'>
                        <img src='${url}' width='100' height='100'>
                        <a class='del-album' data='${url}'><i class='fa fa-times'></i></a>
                    </div>`;
                });
                
                $("." + callback).prepend(html);
                $("#" + elementId).val(urls.join(","));
                
                // Re-bind delete event
                $(".del-album").off('click').on('click', function() {
                    const $input = $("#" + elementId);
                    let currentUrls = $input.val().split(",");
                    const removeUrl = $(this).attr("data");
                    
                    currentUrls = currentUrls.filter(u => u !== removeUrl);
                    $input.val(currentUrls.join(","));
                    $(this).parent().remove();
                });
            });
        }
    });
}
</script>
@endsection