@php
// Đọc dữ liệu từ file JSON

$json_file = public_path('template/files/contact_1.json');
if (file_exists($json_file)) {
    $json_content = file_get_contents($json_file);
    $contact_data = json_decode($json_content, true);
} else {
    $contact_data = [];
}
@endphp

<style>
    /* Tùy chỉnh màu nền cho form */
    .form-control-custom {
        /* Màu vàng nhạt (LemonChiffon) */
        background-color: #FFFACD;
        border: 1px solid #ced4da;
    }
    .contact-title {
        color: var(--main-red); /* Màu đỏ cho tiêu đề */
        font-weight: bold;
    }
    .contact-info {
        color: var(--primary-blue); /* Màu xanh dương cho email */
    }
</style>

<div class="row mt-4">
    <div class="col-md-6 mb-4">
        <h1 class="contact-title">{{ $contact_data['main_title'] ?? 'CONTACTEZ-NOUS' }}</h1>
        <p class="color-blue font-italic">{{ $contact_data['welcome_text'] ?? 'Bienvenue sur notre page Contact !' }}</p>
        
        <p class="mt-4">
            {{ $contact_data['description'] ?? 'Une question, une envie, une suggestion ? Si une information vous manque ou si vous souhaitez simplement échanger avec nous, n’hésitez pas à nous écrire. Nous serons ravis de vous lire et de vous répondre dans les meilleurs délais.' }}
        </p>
        
        <div class="d-flex align-items-center mt-4 contact-info">
            <i class="fas fa-envelope mr-2"></i> 
            <p class="mb-0">{{ $contact_data['contact_email'] ?? 'info@vnct.org' }}</p>
        </div>
    </div>

    <div class="col-md-6">
        @if(session('success'))
            <div class="alert alert-success">
                {{ $contact_data['success_message'] ?? 'Votre message a été envoyé avec succès !' }}
            </div>
        @endif
        @if(session('failed'))
            <div class="alert alert-danger">
                {{ $contact_data['failed_message'] ?? 'Une erreur s\'est produite. Veuillez réessayer.' }}
            </div>
        @endif
        
        <form action="/sendmail" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control form-control-custom" 
                           name="name" 
                           placeholder="{{ $contact_data['name_label'] ?? 'Nom et Prénom*' }}" 
                           required>
                </div>
                <div class="form-group col-md-6">
                    <input type="email" class="form-control form-control-custom" 
                           name="email" 
                           placeholder="{{ $contact_data['email_label'] ?? 'Email*' }}" 
                           required>
                </div>
            </div>

            <div class="form-group">
                <input type="text" class="form-control form-control-custom" 
                       name="subject" 
                       placeholder="{{ $contact_data['subject_label'] ?? 'Sujet*' }}" 
                       required>
            </div>

            <div class="form-group">
                <textarea class="form-control form-control-custom" 
                          name="content" 
                          rows="4" 
                          placeholder="{{ $contact_data['content_label'] ?? 'Message*' }}" 
                          required></textarea>
            </div>

            <button type="submit" class="btn background-blue text-white btn-block py-2">
                {{ $contact_data['submit_button'] ?? 'SOUMETTRE MAINTENANT' }}
            </button>
        </form>
    </div>
    
    <div class="col-12 mt-4">
        @if(!empty($contact_data['map_embed']))
            <iframe src="{{ $contact_data['map_embed'] }}" 
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        @else
            <div class="alert alert-info">
                Carte non disponible. Veuillez configurer l'URL Google Maps dans l'administration.
            </div>
        @endif
    </div>
</div>