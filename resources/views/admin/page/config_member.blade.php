<?php
// Kiểm tra đăng nhập
$is_logged_in = true;

// Đường dẫn file JSON cho trang thành viên
$locale = \App::getLocale();

$json_file = public_path('template/files/membres_' . $locale . '.json');

// Đọc dữ liệu từ file JSON
if (file_exists($json_file)) {
    $json_content = file_get_contents($json_file);
    $data = json_decode($json_content, true);
} else {
    $data = [];
}
?>

<!-- Phần Tiêu đề chính -->

<!-- Tiêu đề các tab -->
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Tiêu đề tab 1 (Membre officiel)</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề tab 1" 
           value="{{ $data['tab1_title'] ?? 'Membre officiel' }}" 
           name="membres_tab1_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Nội dung tab 1 (Membre officiel) - CKEditor</label>
    <textarea class="form-control ckeditor" name="membres_tab1_content" rows="10">{{ $data['tab1_content'] ?? '<p><strong>Définition :</strong></p>
<p>Entreprises, organisations, individus, associations… approuvant le Statut de l’Association</p>
<p>Faire la demande d’adhésion officielle</p>
<p>S’acquittant des frais d’adhésion.</p>
<p><strong>Avantages :</strong></p>
<p><strong>Coopération & Réseautage :</strong></p>
<p>Augmenter les possibilités de partenariat avec des entreprises et investisseurs du secteur touristique en Europe et en France.</p>
<p><strong>Assistance technique :</strong></p>
<p>Profiter des expériences d’autres membres pour promouvoir les activités de communication culturelle et touristique.</p>
<p><strong>Conseils & Informations :</strong></p>
<p>Accès à des conseils professionnels, aux informations nécessaires et supports numériques adaptés au marché pour la promotion des membres.</p>
<p><strong>Visibilité :</strong></p>
<p>Droit d’être mentionné dans l’annuaire des membres sur le site de l’Association et dans les publications diffusées lors d’événements culturels et touristiques.</p>
<p><strong>Participation aux événements :</strong></p>
<p>Accès à tous les événements de promotion organisés par l’Association bénéficiant des conditions spéciales sur les frais de participation.</p>
<p><strong>Droits de vote & de candidature :</strong></p>
<p>Possibilité de se présenter ou d’être nommé au Comité exécutif et de participer aux votes concernant les dépenses, l’organisation et le fonctionnement de l’Association.</p>' }}</textarea>
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Tiêu đề tab 2 (Membres bienfaiteurs)</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề tab 2" 
           value="{{ $data['tab2_title'] ?? 'Membres bienfaiteurs' }}" 
           name="membres_tab2_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Nội dung tab 2 (Membres bienfaiteurs) - CKEditor</label>
    <textarea class="form-control ckeditor" name="membres_tab2_content" rows="5">{{ $data['tab2_content'] ?? '<p>Les personnes, unités ou organisations ayant apporté des contributions particulières au développement de l’Association.</p>
<p>Elles sont reconnues par l’Association comme membres bienfaiteurs.</p>' }}</textarea>
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Tiêu đề tab 3 (Membres d\'honneur)</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề tab 3" 
           value="{{ $data['tab3_title'] ?? 'Membres d\'honneur' }}" 
           name="membres_tab3_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Nội dung tab 3 (Membres d\'honneur) - CKEditor</label>
    <textarea class="form-control ckeditor" name="membres_tab3_content" rows="5">{{ $data['tab3_content'] ?? '<p>Les personnes, unités ou organisations ayant apporté des contributions importantes au développement de l’Association.</p>
<p>Elles sont invitées par l’Association à devenir membres d\'honneur.</p>' }}</textarea>
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Tiêu đề tab 4 (Membres associés)</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề tab 4" 
           value="{{ $data['tab4_title'] ?? 'Membres associés' }}" 
           name="membres_tab4_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Nội dung tab 4 (Membres associés) - CKEditor</label>
    <textarea class="form-control ckeditor" name="membres_tab4_content" rows="5">{{ $data['tab4_content'] ?? '<p>Ce sont des entreprises, des particuliers ou des unités administratives exerçant des activités associatives et commerciales légales dans les domaines de la culture, du tourisme et des services touristiques.</p>
<p>Ils partagent les mêmes objectifs d\'activité que l\'Association.</p>
<p>Ayant déjà participé à une campagne de promotion, un salon, une action de communication… conjointement avec l\'Association.</p>' }}</textarea>
</div>

<!-- Phần hỗ trợ -->
<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Tiêu đề phần hỗ trợ</label>
    <input type="text" class="form-control" 
           placeholder="Nhập tiêu đề phần hỗ trợ" 
           value="{{ $data['support_title'] ?? 'SOUTENIR VNCT' }}" 
           name="membres_support_title" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Văn bản nút hỗ trợ</label>
    <input type="text" class="form-control" 
           placeholder="Nhập văn bản nút hỗ trợ" 
           value="{{ $data['support_button'] ?? 'SOUTIEN' }}" 
           name="membres_support_button" />
</div>

<div class="form-group">
    <label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Đường dẫn liên kết hỗ trợ</label>
    <input type="text" class="form-control" 
           placeholder="Nhập đường dẫn liên kết" 
           value="{{ $data['support_link'] ?? '/contacto' }}" 
           name="membres_support_link" />
</div>

<!-- CKEditor Script -->
@push('scripts')

<script>
    $(document).ready(function() {
        // Khởi tạo CKEditor cho tất cả textarea có class 'ckeditor'
        $('.ckeditor').each(function() {
            
        CKEDITOR.replace(this, {
            uiColor: '#ebf2f6',
            language: 'vi',
            filebrowserImageBrowseUrl: '{{ route('ckfinder_browser') }}?resourceType=Images',
            filebrowserImageUploadUrl: '{{ route('ckfinder_connector') }}?command=QuickUpload&resourceType=Images'
        });
   
            
        });
    });
</script>
@endpush