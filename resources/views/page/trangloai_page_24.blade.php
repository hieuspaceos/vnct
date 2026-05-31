<?php
$json_file = public_path('template/files/introduccion_2.json');

if (file_exists($json_file)) {

    $json_content = file_get_contents($json_file);

    $data_intro = json_decode($json_content, true);   
    if ($data_intro === null) {
        $data_intro = [];
    }
} else {
    $data_intro = [];
}
?>
<div>
    <section class="section">
        <h2>{{ $data_intro['intro_title'] ?? 'Introducción a VNCT' }}</h2>
        <p style="text-align: justify; font-size: 1.1em;">
            <strong>{{ $data_intro['intro_content'] ?? 'VNCT (Asociación para la Promoción de la Cultura y el Turismo de Vietnam en Francia y Europa) es una organización sin ánimo de lucro dedicada a fomentar el intercambio cultural, impulsar el turismo sostenible y fortalecer los lazos económicos y sociales entre Vietnam y el continente europeo. Servimos como puente, facilitando la colaboración entre instituciones, empresas y ciudadanos. Nuestro objetivo es posicionar a Vietnam como un destino cultural y turístico clave en Europeo, destacando su rica herencia y su dinamismo moderno.' }}</strong>
        </p>
    </section>
    
    <section class="section bg-blue">
        <h2 style="color: white;">{{ $data_intro['strategy_title'] ?? 'Nuestra Estrategia' }}</h2>
        <div class="grid-2">
            <div class="strategy-item">
                <h3>{{ $data_intro['strategy1_title'] ?? 'Digitalización' }}</h3>
                <p>{{ $data_intro['strategy1_content'] ?? 'Crear plataformas interactivas de última generación para mostrar la riqueza cultural y los destinos turísticos de Vietnam a una audiencia global.' }}</p>
            </div>
            <div class="strategy-item">
                <h3>{{ $data_intro['strategy2_title'] ?? 'Sostenibilidad' }}</h3>
                <p>{{ $data_intro['strategy2_content'] ?? 'Promover el turismo responsable y proyectos de development que beneficien directamente a las comunidades locales y preserven el patrimonio natural.' }}</p>
            </div>
            <div class="strategy-item">
                <h3>{{ $data_intro['strategy3_title'] ?? 'Alianzas' }}</h3>
                <p>{{ $data_intro['strategy3_content'] ?? 'Establecer acuerdos de cooperación con operadores turísticos europeos, museos, universidades y cámaras de comercio de la UE.' }}</p>
            </div>
            <div class="strategy-item">
                <h3>{{ $data_intro['strategy4_title'] ?? 'Eventos de Alto Impacto' }}</h3>
                <p>{{ $data_intro['strategy4_content'] ?? 'Organizar festivales culturales, seminarios de inversión y exposiciones de arte vietnamita en las principales capitales europeas.' }}</p>
            </div>
        </div>
    </section>

    <section class="section">
    <h2>{{ $data_intro['board_title'] ?? 'Junta Directiva y Consejo de Administración' }}</h2>
    
    @php
    $member_hoidongquantri = App\Models\Portfolio::where('member_id', $data_intro['board_data'])->get();
    @endphp

    {{-- Hàng 1: 1 người (index 0) --}}
    @if($member_hoidongquantri->count() > 0)
    <div class="single-member-row" style="display: flex; justify-content: center; margin-bottom: 30px;">
        @php $member = $member_hoidongquantri[0]; @endphp
        <div class="member-card-v2 w-100 w-lg-25" >
            <div class="card-header-v2">
                <a href="{{ $member['avatar'] }}" data-fancybox="gallery" data-caption="{{ $member['name'] }}">
                    <img src="{{ $member['avatar'] }}" alt="{{ $member['name'] }}" class="member-avatar-v2">
                </a>
            </div>
            <span class="member-type-v2">{{ $member['type'] }}</span>
            <div class="card-body-v2" data-content="{{ base64_encode($member['content']) }}" 
     data-avatar="{{ $member['avatar'] }}" data-name="{{ $member['name'] }}" onclick="showchitiet(this)">
                <h3 class="company-name-v2">{{ $member['name'] }}</h3>
                <div class="info-group">
                    <p class="contact-person-v2">
                        <i class="fas fa-user"></i> {{ $member['username'] }} | {{ $member['position'] }}
                    </p>
                    <p class="location-area-v2">
                        <i class="fas fa-globe"></i> {{ $member['location'] }}
                        <span class="area-separator">|</span> 
                        {{ $member['area_of_operation'] }}
                    </p>
                </div>
                <a href="mailto:{{ $member['email'] }}" class="email-link-v2">
                    <i class="fas fa-envelope"></i> {{ $member['email'] }}
                </a>
            </div>
            <div class="card-footer-v2">
                <small><?=df117?>: {{ date('d/m/Y', strtotime($member['created_at'])) }}</small>
            </div>
        </div>
    </div>
    @endif

    {{-- Hàng 2: 4 người (index 1-4) --}}
    @if($member_hoidongquantri->count() > 1)
    <div class="grid-4" >
        @for($i = 1; $i <= $member_hoidongquantri->count() - 1; $i++)
            @php $member = $member_hoidongquantri[$i]; @endphp
            <div class="member-card-v2">
                <!-- Copy toàn bộ cấu trúc card giống hàng 1 nhưng bỏ style max-width -->
                <div class="card-header-v2">
                    <a href="{{ $member['avatar'] }}" data-fancybox="gallery" data-caption="{{ $member['name'] }}">
                        <img src="{{ $member['avatar'] }}" alt="{{ $member['name'] }}" class="member-avatar-v2">
                    </a>
                </div>
                <span class="member-type-v2">{{ $member['type'] }}</span>
                <div class="card-body-v2" data-content="{{ base64_encode($member['content']) }}" 
     data-avatar="{{ $member['avatar'] }}" data-name="{{ $member['name'] }}" onclick="showchitiet(this)">
                    <h3 class="company-name-v2">{{ $member['name'] }}</h3>
                    <div class="info-group">
                        <p class="contact-person-v2">
                            <i class="fas fa-user"></i> {{ $member['username'] }} | {{ $member['position'] }}
                        </p>
                        <p class="location-area-v2">
                            <i class="fas fa-globe"></i> {{ $member['location'] }}
                            <span class="area-separator">|</span> 
                            {{ $member['area_of_operation'] }}
                        </p>
                    </div>
                    <a href="mailto:{{ $member['email'] }}" class="email-link-v2">
                        <i class="fas fa-envelope"></i> {{ $member['email'] }}
                    </a>
                </div>
                <div class="card-footer-v2">
                    <small><?=df117?>: {{ date('d/m/Y', strtotime($member['created_at'])) }}</small>
                </div>
            </div>
        @endfor
    </div>
    @endif

  
</section>

    <section class="section">
        <h2>{{ $data_intro['members_title'] ?? 'Nuestros Miembros Oficiales' }}</h2>
        <div class="owl-carousel owl-theme" id="miembros">
           @php
            $member_chinhthuc = App\Models\Portfolio::where('member_id',$data_intro['members_data'])->get();
            @endphp
            @foreach($member_chinhthuc as $member)
            <div class="member-card-v2">
                <div class="card-header-v2">
                     <a
  href="{{ $member['avatar'] }}"
  data-fancybox="gallery"
  data-caption="{{ $member['name'] }}"
>
                    <img src="{{ $member['avatar'] }}" alt="{{ $member['name'] }}" class="member-avatar-v2">
                    <a>
                </div>
                <span class="member-type-v2">{{ $member['type'] }}</span>
                <div class="card-body-v2">
                    <h3 class="company-name-v2">{{ $member['name'] }} </h3>
                    <div class="info-group">
                        <p class="contact-person-v2">
                            <i class="fas fa-user"></i> {{ $member['username'] }} | {{ $member['position'] }}
                        </p>
                        <p class="location-area-v2">
                            <i class="fas fa-globe"></i> {{ $member['location'] }}
                            <span class="area-separator">|</span> 
                            {{ $member['area_of_operation'] }}
                        </p>
                    </div>
                    <a href="mailto:{{ $member['email'] }}" class="email-link-v2">
                        <i class="fas fa-envelope"></i> {{ $member['email'] }}
                    </a>
                </div>
                <div class="card-footer-v2">
                    <small><?=df117?>: {{ date('d/m/Y', strtotime($member['created_at'])) }}</small>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <div class="page-presentation">
        <div class="section-3 my-5">
            <h3 class="text-center">{{ $data_intro['domaines_title'] ?? 'LES DOMAINES D\'ACTIVITÉ PRINCIPAUX DE VNCT' }}</h3>
            <div class="row mt-5">
                <div class="col-12 col-lg-4 section-3-item">
                    <i class="fa-solid fa-people-group"></i>
                    <p>{{ $data_intro['domaines1_content'] ?? 'Participer directement et co-organiser des événements liés à la culture et au tourisme.' }}</p>
                </div>
                <div class="col-12 col-lg-4 section-3-item">
                    <i class="fa-solid fa-plane"></i>
                    <p>{{ $data_intro['domaines2_content'] ?? 'Faciliter la connexion BtoB des entreprises lors d\'événements culturels et touristiques en Europe par VNCT.' }}</p>
                </div>
                <div class="col-12 col-lg-4 section-3-item">
                    <i class="fa-solid fa-handshake"></i>
                    <p>{{ $data_intro['domaines3_content'] ?? 'Observer toutes les procédures et règles administratives légales de l\'association conformément aux autorités locales' }}</p>
                </div>
            </div>
        </div>

        <div class="section-3 my-5">
            <h3 class="text-center">{{ $data_intro['responsabilities_title'] ?? 'RESPONSABILITÉS DE L\'ASSOCIATION' }}</h3>
            <div class="row mt-5">
                <div class="col-12 col-lg-4 section-3-item">
                    <i class="fa-solid fa-people-group"></i>
                    <p>{{ $data_intro['responsabilities1_content'] ?? 'Protéger les droits des membres de l\'association.' }}</p>
                </div>
                <div class="col-12 col-lg-4 section-3-item">
                    <i class="fa-solid fa-star"></i>
                    <p>{{ $data_intro['responsabilities2_content'] ?? 'Promotion du tourisme et de la culture vietnamiens en Europe, en s\'appuyant sur l\'expertise des membres au Vietnam et en Europe.' }}</p>
                </div>
                <div class="col-12 col-lg-4 section-3-item">
                    <i class="fa-solid fa-file"></i>
                    <p>{{ $data_intro['responsabilities3_content'] ?? 'Observer toutes les procédures et règles administratives légales de l\'association conformément aux autorités locales' }}</p>
                </div>
            </div>
        </div>

        <div class="section-5 my-5">
            <h3>{{ $data_intro['section5w_title'] ?? '5W de VNCT' }}</h3>
            <p style="color: #133397; font-weight: bold;">{{ $data_intro['section5w_subtitle'] ?? 'MAISON DU TOURISME VIETNAMIEN EN EUROPE - NGÔI NHÀ DU LỊCH VIỆT NAM TẠI CHÂU ÂU' }}</p>
            
            <h3 class="text-center my-4" style="color: #000;">{{ $data_intro['what_title'] ?? 'What?' }}</h3>
            <p>{{ $data_intro['what_content'] ?? 'VNCT est une Association loi 1901 dont le siège est à Paris. Les membres sont les entreprises, individuels, organisations… travaillant dans le tourisme et la culture. Nous visons à se rassembler nos forces pour une présence durable et fréquente auprès des marchés BtoB et BtoC en Europe.' }}</p>
            
            <div class="row section-5-grid my-5">
                <div class="col-12 section-5-grid-item p-0">
                    <h3>{{ $data_intro['how_title'] ?? 'HOW (WOH)?' }}</h3>
                    <p>{{ $data_intro['how_content1'] ?? 'Activités, budget, organisation sont décidés par les membres et le Comité exécutif avec un Backoffice' }}</p>
                    <p>{{ $data_intro['how_content2'] ?? 'Nous développons ces activités' }}</p>
                </div>
                <div class="col-12 section-5-grid-item">
                    <i class="fa-solid fa-handshake"></i>
                    <div>{{ $data_intro['pros_title'] ?? 'Activités pros' }}</div>
                    <ul>
                        @for($i = 1; $i <= 5; $i++)
                        @if(!empty($data_intro['pros_item' . $i]))
                        <li>{{ $data_intro['pros_item' . $i] }}</li>
                        @endif
                        @endfor
                    </ul>
                </div>
                <div class="col-12 section-5-grid-item">
                    <i class="fa-solid fa-audio-description"></i>
                    <div>{{ $data_intro['promo_title'] ?? 'Activités Promotion' }}</div>
                    <ul>
                        @for($i = 1; $i <= 3; $i++)
                        @if(!empty($data_intro['promo_item' . $i]))
                        <li>{{ $data_intro['promo_item' . $i] }}</li>
                        @endif
                        @endfor
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-0">
        <div class="row no-gutters">
            <div class="">
                <div class="info-box bg-red">
                    <i class="fas fa-thumbtack"></i>
                    <h2>{{ $data_intro['where_title'] ?? 'Where? Ở đâu? Où?' }}</h2>
                    <p>{{ $data_intro['where_vn'] ?? 'Châu Âu, Pháp và Việt Nam' }}</p>
                    <p>{{ $data_intro['where_fr'] ?? 'Europe, France et Vietnam' }}</p>
                </div>
            </div>

            <div class="">
                <div class="info-box bg-dark-blue">
                    <i class="far fa-clock"></i>
                    <h2>{{ $data_intro['when_title'] ?? 'When? Khi nào? Quand?' }}</h2>
                    <p>{{ $data_intro['when_vn1'] ?? 'Cả năm – nhiều năm' }}</p>
                    <p>{{ $data_intro['when_fr1'] ?? 'Toute l\'année, plusieurs années' }}</p>
                    <p>{{ $data_intro['when_vn2'] ?? 'Liên tục – Lâu dài – Bền vững' }}</p>
                    <p>{{ $data_intro['when_fr2'] ?? 'Fréquence – Durabilité' }}</p>
                </div>
            </div>

            <div class="">
                <div class="info-box bg-yellow">
                    <i class="far fa-user"></i>
                    <h2>{{ $data_intro['who_title'] ?? 'Who? Với những ai? Avec qui?' }}</h2>
                    <p>{{ $data_intro['who_content'] ?? 'Cá nhân, doanh nghiệp, sở văn hóa du lịch, sở du lịch, hội nghề nghiệp...' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container data-media-section my-5">
        <h2 class="section-title-large mb-4">{{ $data_intro['video_title'] ?? 'Video' }}</h2>
        <div class="owl-carousel owl-theme" id="video">
            @php 
            $slides = json_decode(df104 ?? '[]', true);                
            @endphp
            @for($i = 0; $i < count($slides); $i += 3)
            <div class="item" data-video="{{ $slides[$i] }}">
                <div class="media-card-3-col">
                    <div class="media-thumbnail video-thumb">
                        <img src="{{ $slides[$i+1] }}" class="img-fluid card-img-top" alt="Chùa Một Cột">
                        <i class="fas fa-play-circle play-icon"></i>
                    </div>
                    <div class="card-body-content pt-3">
                        {!! $slides[$i+2] !!}
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>

    <div class="modal fade" id="videoModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <button type="button" class="close p-2" data-dismiss="modal" aria-label="Close" 
                        style="position:absolute; right:10px; z-index:10; font-size:32px;">
                        &times;
                    </button>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe id="videoFrame" class="embed-responsive-item" src="" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <h2>{{ $data_intro['culture_title'] ?? 'Descubre: Cultura y Turismo' }}</h2>
        <div class="owl-carousel owl-theme" id="vanhoadulich">
            @php
                use App\Models\Terms;
                use App\Models\Posts;
                use App\Helpers\Helper;
                
                if (!empty($data_intro['culture_id'])) {
                    $vanhoa_term = Terms::find($data_intro['culture_id']);

                    if ($vanhoa_term) {
                        $array_child_id = Helper::user_all_childs_ids($vanhoa_term);
                        array_push($array_child_id, $data_intro['culture_id']);
                       
                        $vanhoaduclich = Posts::with('Terms')
                            ->whereHas('Terms', function($query) use($array_child_id) {
                                $query->whereIn("id", $array_child_id);
                            })
                            ->where('Post_Status', 1)
                            ->take(6)
                            ->orderByDesc('created_at')
                            ->get();
                       
                        foreach($vanhoaduclich as $v) {
                            echo '<div class="">';
                            echo Helper::template_tintuc($v);
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="alert alert-info">Danh mục không tồn tại</div>';
                    }
                } else {
                    echo '<div class="alert alert-info">Vui lòng cấu hình ID danh mục</div>';
                }
            @endphp
        </div>
    </section>

    <div class="container connect">
        <div class="connect-content">
            <h2>{{ $data_intro['contact_title'] ?? 'Contacto' }}</h2>
            <a href="{{ $data_intro['link_contact_button'] ?? '#' }}">
                <button class="btn btn-outline-primary btn-sm custom-load-more">{{ $data_intro['contact_button'] ?? 'Ver más' }}</button>
            </a>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_chitiet" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content"> 
        <button type="button" class="custom-close" data-dismiss="modal" aria-label="Close">
        &times;
      </button>    
      <div class="modal-body p-0"> <div class="row no-gutterss h-100">
                <div class="col-md-8 modal_chitiet_left">
                </div>
                
                <div class="col-md-4 modal_chitiet_right">
                    </div>
            </div>
      </div>
    </div>
  </div>
</div>
@push('css')
<style type="text/css">
    .custom-close {
    position: absolute;
    right: 15px;
    top: 10px;
    z-index: 1051; /* Cao hơn nội dung modal */
    background: rgba(0, 0, 0, 0.2); /* Nền mờ để thấy rõ trên cả ảnh và text */
    color: white;
    border: none;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    font-size: 24px;

    line-height: 25px;
    display: flex;
   
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    outline: none !important;
}
.custom-close:hover {
    background: rgba(0, 0, 0, 0.5);
    color: #fff;
    transform: rotate(90deg); /* Hiệu ứng xoay nhẹ khi hover cho vui mắt */
}

    /* Thiết lập cho PC (Màn hình từ 768px trở lên) */
@media (min-width: 768px) {
    /* Ép Modal rộng ra để chứa đủ 2 cột 8-4 */
    #modal_chitiet .modal-dialog {
        max-width: 90%; 
        margin: 5vh auto; /* Cách trên dưới 5% */
    }

    #modal_chitiet .modal-content {
        height: 90vh; /* Chiều cao cố định 90% màn hình */
        overflow: hidden; /* Ngăn không cho toàn bộ modal cuộn */
    }

    #modal_chitiet .modal-body {
        height: 100%;
        padding: 0; /* Xóa padding để nội dung sát mép nếu cần */
    }

    #modal_chitiet .row {
        height: 100%;
        margin: 0;
    }

    /* CỘT TRÁI: Cho phép cuộn */
    .modal_chitiet_left {
        height: 100%;
        overflow-y: auto;
        padding: 20px;
    }

    /* CỘT PHẢI: Hình ảnh cố định */
    .modal_chitiet_right {
        height: 100%;
        padding: 0;
        background-color: #f8f9fa;
    }

    .modal_chitiet_right img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Ảnh phủ kín cột không bị méo */
    }
}

/* Thiết lập cho Mobile (Dưới 768px) */
@media (max-width: 767.98px) {
    .modal_chitiet_right {
        order: -1; /* Đưa ảnh lên trên cùng */
        margin-bottom: 15px;
    }
    
    .modal_chitiet_left {
        height: auto;
        overflow: visible;
                padding: 10px 30px;
    }
    
    /* Trên mobile cho phép cuộn toàn bộ modal tự nhiên */
    #modal_chitiet .modal-content {
        height: auto;
    }
}
.info-box {
            min-height: 400px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding: 30px;
            transition: transform 0.3s;

            
        }
        .no-gutters
        {
        	gap:30px;
        	display: grid;
        	grid-template-columns: repeat(3,1fr);
        }
        .info-box:hover {
            transform: scale(1.02);
            z-index: 1;
        }
        .info-box i {
            font-size: 3rem;
            margin-bottom: 20px;
            color: #fff
        }
        .info-box h2 {
            font-weight: bold;
            color: #fff;
            font-size: 1.1rem;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        .info-box p {
            margin-bottom: 5px;
            font-weight: 300;
            color: #fff
        }
        /* Màu sắc tùy chỉnh theo hình ảnh */
        .bg-red { background-color: #d32f2f; }
        .bg-dark-blue { background-color: #0d328d; }
        .bg-yellow { background-color: #e2e26a; color: #333 !important; }
/* Tông màu */
:root {
    --vnct-blue: #003366; /* Xanh Navy Đậm */
    --vnct-gold: #CDA434; /* Vàng Ánh Kim */
    --background-light: #F8F9FA;
    --text-dark: #212529;
    --shadow-color : rgba(0, 0, 0, 0.1);
}


h2 {
    color: var(--main-red);
    text-align: center;
    font-size: 2.5em;
    padding-bottom: 15px;
    margin-bottom: 40px;
    position: relative;
}

h2::after {
    content: '';
    width: 60px;
    height: 4px;
    background-color: var(--vnct-gold);
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    border-radius: 2px;
}

/* --- Section Styling --- */
.section {
   margin: 40px 0;
}

.bg-blue {
    background-color: var(--vnct-blue);
    color: #ffffff;
    padding: 80px 20px;
}
p{color: #000}

/* --- Card Grid Layout --- */
.grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.grid-2 {
    display: grid;
    grid-template-columns: repeat(2,1fr);
    gap: 30px;
}

.card {
    background-color: #ffffff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
    height: 100%;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.card-content {
    padding: 20px;
}

.card-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.card-title {
    color: var(--vnct-blue);
    font-size: 1.25em;
    margin-top: 0;
    border-bottom: 2px solid var(--vnct-gold);
    padding-bottom: 5px;
}

/* --- Miembro Card Specific --- */
.member-card .card-img {
    border-radius: 50%;
    width: 120px;
    height: 120px;
    margin: 20px auto 0;
    display: block;
    border: 4px solid var(--vnct-gold);
}

.member-card .card-content {
    text-align: center;
    padding-top: 10px;
}

/* --- Estrategia --- */
.strategy-item {
    background-color: #ffffff;
    padding: 25px;
    border-left: 5px solid var(--vnct-gold);
    border-radius: 4px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.strategy-item h3 {
    color: var(--vnct-blue);
    margin-top: 0;
}
.member-card-v2 {
    background-color: #ffffff;
    border-radius: 16px; /* Bo góc lớn hơn */
    box-shadow: 0 4px 10px var(--shadow-color);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align: center;
    padding-top: 0;
    position: relative;
    height: 100%;
}

/* Hiệu ứng HOVER (Nâng nhẹ và làm bóng rõ hơn) */
.member-card-v2:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
}

/* Phần Header & Avatar */
.card-header-v2 {
    background-color: var(--primary-blue);
    height: 90px;
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
    margin-bottom: 70px; /* Tạo khoảng trống cho avatar */
}

.member-avatar-v2 {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 6px solid #ffffff; /* Viền trắng dày */
    object-fit: cover;
    position: absolute;
    top: 25px; /* Đặt chồng lên header và body */
    left: 50%;
    transform: translateX(-50%);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Badge Loại hình */
.member-type-v2 {
    position: absolute;
    top: 15px;
    right: 15px;
    background-color: var(--light-blue);
    color: #ffffff;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* Phần Body (Thông tin Chính) */
.card-body-v2 {
    padding: 0 20px 20px 20px;
    cursor: pointer;
}

.company-name-v2 {
    color: var(--primary-blue);
    font-size: 1.4rem;
    font-weight: 800;
    margin-bottom: 15px;
    line-height: 1.2;
        height: 57px;
    overflow: hidden;
}

.info-group {
    border-top: 1px solid var(--border-soft);
    padding-top: 15px;
    margin-bottom: 15px;
}

.contact-person-v2,
.location-area-v2 {
    color: var(--text-dark);
    font-size: 0.9rem;
    margin-bottom: 8px;
    font-weight: 500;
}

.location-area-v2 .area-separator {
    margin: 0 8px;
    color: var(--text-muted);
}

/* Icon */
.card-body-v2 i {
    color: var(--light-blue);
    margin-right: 8px;
    width: 18px; /* Giữ icon nhất quán */
    text-align: center;
}

/* Liên kết Email */
.email-link-v2 {
    color: var(--text-muted);
    text-decoration: none;
    font-size: 0.85rem;
    display: block;
    margin-top: 10px;
    transition: color 0.3s ease;
}

.email-link-v2:hover {
    color: var(--light-blue);
    text-decoration: underline;
}

/* Phần Footer (Metadata) */
.card-footer-v2 {
    padding: 15px 20px;
    background-color: var(--border-soft);
    border-bottom-left-radius: 16px;
    border-bottom-right-radius: 16px;
    text-align: right;
}

.card-footer-v2 small {
    color: var(--text-muted);
    font-size: 0.75rem;
}
</style>
@endpush
@push('css')
    <style>
        /* CSS nguyên gốc giữ nguyên */
        .page-presentation .section-1-1 {
            font-weight: 500;
            font-style: normal;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #133397;
            margin-bottom: 12px;
        }
        .page-presentation .section-1-2 {
            font-size: 42px;
            font-weight: 500;
            letter-spacing: 0px;
            text-transform: none;
            color: #d8271c;
        }
        .page-presentation .gdlr-core-pbf-wrapper-container>.gdlr-core-pbf-element {
            width: 100%;
        }
        .page-presentation .gdlr-core-pbf-wrapper-full-no-space .gdlr-core-item-pdlr {
            padding-left: 0;
            padding-right: 0;
        }
        .page-presentation .gdlr-core-divider-item {
            position: relative;
            z-index: 1;
            margin-bottom: 30px;
        }
        .page-presentation .gdlr-core-divider-item-center-circle .gdlr-core-divider-line {
            position: relative;
        }
        .page-presentation .gdlr-core-divider-item-center-circle .gdlr-core-divider-line:before {
            content: " ";
            display: block;
            position: absolute;
            top: 13px;
            left: 0;
            right: 50%;
            margin-right: 13px;
            border-bottom-width: 1px;
            border-bottom-style: solid;
        }
        .page-presentation .gdlr-core-divider-item-center-circle .gdlr-core-divider-line-bold:before {
            content: " ";
            display: block;
            width: 14px;
            height: 14px;
            margin: 5px;
            border-width: 1px;
            border-style: solid;
            border-radius: 7px;
            -moz-border-radius: 7px;
            -webkit-border-radius: 7px;
        }
        .page-presentation .gdlr-core-divider-item-center-circle .gdlr-core-divider-line-bold {
            width: 26px;
            height: 26px;
            margin: 0 auto;
            border-width: 1px;
            border-style: solid;
            border-radius: 13px;
            -moz-border-radius: 13px;
            -webkit-border-radius: 13px;
        }
        .page-presentation .gdlr-core-divider-item-center-circle .gdlr-core-divider-line:after {
            content: " ";
            display: block;
            position: absolute;
            top: 13px;
            right: 0;
            left: 50%;
            margin-left: 13px;
            border-bottom-width: 1px;
            border-bottom-style: solid;
        }
        .page-presentation h3 {
            font-size: 34px;
            font-weight: 500;
            letter-spacing: 0px;
            text-transform: none;
            color: #d8271c;
        }
        .page-presentation i {
            color: #133397;
            font-size: 30px;
        }
        .page-presentation .section-3-item {
            display: grid;
            text-align: center;
            gap:20px;
        }
        .page-presentation .section-3-item p {
            font-weight: bold;
        }
        .page-presentation .my-5 {
            margin: 80px 0 !important;
        }
        .page-presentation .section-4-1 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
        }
        .page-presentation .section-4-1-item {
            padding:30px 20px;
            color: #fff;
            display: grid;
            gap: 10px;
        }
        .page-presentation .section-4-1-item:nth-child(1) {
            background: #133397;
        }
        .page-presentation .section-4-1-item:nth-child(2) {
            background:#155fd6;
        }
        .page-presentation .section-4-1-item:nth-child(3) {
            background: #d8271c;
        }
        .page-presentation .section-4-1-item:nth-child(4) {
            background: #a81515;
        }
        .page-presentation .section-4-1-item i {
            font-size: 38px;
            color: #fff;
        }
        .page-presentation .section-4-1-title {
            font-size: 23px;
        }
        .page-presentation .section-4-1-item hr {
            border-bottom-style: solid;
            border-color: #e1e1e1;
            width: 100%;
        }
        .page-presentation .section-5-grid {
            display: grid;
            grid-template-columns: repeat(3,1fr);
            gap:30px;
        }
        .page-presentation .section-5-grid-item i {
            color: #fff;
        }
        .page-presentation .section-5-grid-item:nth-child(2),
        .page-presentation .section-5-grid-item:nth-child(3) {
            text-align: center;
            color: #fff;
            padding: 30px 20px;
        }
        .page-presentation .section-5-grid-item ul {
            margin: 0;
            padding: 0;
            text-align: left;
            padding-left: 20px;
        }
        .page-presentation .section-5-grid-item ul li {
            list-style-type: disc;
        }
        .page-presentation .section-5-grid-item div {
            margin: 20px 0;
            font-size: 22px;
            font-weight: 700;
        }
        .page-presentation .section-5-grid-item:nth-child(2) {
            background: rgb(7, 48, 142);
        }
        .page-presentation .section-5-grid-item:nth-child(3) {
            background: rgb(217, 40, 29);
        }
        .page-presentation .section-5-grid-item:nth-child(1) h3 {
            color: var(--primary-blue);
        }
        @media screen and (max-width:1024px ) {
            .section-4-1 {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            .page-presentation .section-5-grid {
                grid-template-columns: repeat(1, 1fr) !important;
            }
            .no-gutters
	        {
	        	
	        	grid-template-columns: repeat(2,1fr);
	        }
        }
        @media screen and (max-width:768px ) {
        	.no-gutters
	        {
	        	
	        	grid-template-columns: repeat(1,1fr);
	        }
            .section-4-1 {
                grid-template-columns: repeat(1, 1fr) !important;
            }
            .page-presentation .section-1-2,
            .page-presentation h3 {
                font-size: 25px;
            }
            .page-presentation .my-5 {
                margin: 40px 0 !important;
            }
        }
    </style>
@endpush
@push('js')
<script type="text/javascript">
    function showchitiet(element) {
        try {
            // Lấy chuỗi base64 từ attribute
            const base64 = element.getAttribute('data-content');
            
            // Giải mã Unicode an toàn
            const content = decodeURIComponent(escape(atob(base64)));
            
            const avatar = element.getAttribute('data-avatar');

            const name = element.getAttribute('data-name');

            $(".modal_chitiet_left").html(content);
            $(".modal_chitiet_left").prepend("<h3>"+name+"</h3>");
            // Thêm class img-fluid của Bootstrap để ảnh không bị tràn
            $(".modal_chitiet_right").html("<img src='" + avatar + "' class='img-fluid' >");
            $("#modal_chitiet").modal("show");
            
        } catch (e) {
            console.error("Lỗi giải mã nội dung:", e);
        }
    }
    $(document).ready(function () {

    // Click vào thumbnail để mở popup
    $('#video .video-thumb').on('click', function () {
        let videoUrl = $(this).closest('.item').data('video');

        if (videoUrl) {
            // Chuyển sang dạng embed
            let embedUrl = videoUrl.replace("watch?v=", "embed/");

            $("#videoFrame").attr("src", embedUrl + "?autoplay=1");

            $("#videoModal").modal("show");
        }
    });

    // Khi đóng modal thì dừng video
    $('#videoModal').on('hidden.bs.modal', function () {
        $("#videoFrame").attr("src", "");
    });

});
	$(document).ready(function(){
		
		$('#vanhoadulich').owlCarousel({
            loop:true,
            margin:10,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1,
                    nav:false
                },
                600:{
                    items:2,
                    nav:false
                },
                1000:{
                    items:3,
                    nav:false,
                    loop:false
                }
            }
        });
		$('#miembros').owlCarousel({
		    loop:true,
		    margin:10,
		    responsiveClass:true,
		    responsive:{
		        0:{
		            items:1,
		            nav:false
		        },
		        600:{
		            items:2,
		            nav:false
		        },
		        1000:{
		            items:3,
		            nav:false,
		            loop:false
		        }
		    }
		});
	});
</script>
@endpush