{{-- trangloai_page_presentation.blade.php --}}
<?php
$json_file = public_path('template/files/presentation_2.json');

if (file_exists($json_file)) {
    $json_content = file_get_contents($json_file);
    $data = json_decode($json_content, true);
    
    if ($data === null) {
        $data = [];
    }
} else {
    $data = [];
}
?>

<div class="page-presentation">
    <div class="section-1">
        <div class="text-center section-1-1">{{ $data['section1_title'] ?? 'Association pour la Culture et le Tourisme du Vietnam en Europe' }}</div>
        <div class="text-center section-1-2">{{ $data['section1_subtitle'] ?? 'Vietnam Culture & Tourism in Europe Association (VNCT)' }}</div>
    </div>
    
    <div class="gdlr-core-pbf-element my-4">
        <div class="gdlr-core-divider-item gdlr-core-divider-item-center-circle gdlr-core-item-pdlr">
            <div class="gdlr-core-divider-line gdlr-core-skin-divider" style="border-color: #133397 ;color: #133397 ;">
                <div class="gdlr-core-divider-line-bold gdlr-core-skin-divider" style="border-color: #133397 ;color: #133397 ;"></div>
            </div>
        </div>
    </div>

    <div class="section-2 row my-5">
        <div class="col-12 col-lg-6 text-center">
            <img src="{{ $data['section2_logo'] ?? '/template/image/vnct-logo.png' }}">
        </div>
        <div class="col-12 col-lg-6 section-2-r">
            <h3>{{ $data['section2_title'] ?? 'VNCT' }}</h3>
            <p style="font-weight: 500; font-style: normal; letter-spacing: 1px; text-transform: uppercase; color: #133397; margin-top: 12px;">
                {{ $data['section2_subtitle'] ?? "est une Association basée à Paris, agissant conformément à l'Association loi 1901" }}
            </p>
            <p>{{ $data['section2_content1'] ?? "L'association rassemble des entreprises, des organisations, des entités, des associations, des individus, collaborant avec le Centre Culturel Vietnamien en France (CCV) partageant le même objectif de promouvoir le tourisme et la culture vietnamiens en Europe, với une approche professionnelle, visionnaire, constante et durable." }}</p>
            <p>{{ $data['section2_content2'] ?? "Le siège social de l'association est situé au Centre Culturel Vietnamien en France, 19 rue Albert, 75013, Paris." }}</p>
        </div>
    </div>

    

    <div class="section-4 d-none">
        <h3>{{ $data['section5_title'] ?? "MEMBRES DE VNCT" }}</h3>
        <p style="color: #133397; font-weight: bold;">{{ $data['section5_intro'] ?? "Les entreprises, entités, individus, associations, organisations, etc, qui acceptent les règles de l'association, adhèrent volontairement en soumettant une demande d'adhésion et paient les frais d'adhésion peuvent devenir membres de l'association." }}</p>
        <div class="section-4-1 mt-4">
            <div class="section-4-1-item">
                <i class="fa-solid fa-key"></i>
                <div class="section-4-1-title">{{ $data['section5_member1_title'] ?? "Membre officiel" }}</div>
                <hr>
                <p>{{ $data['section5_member1_content'] ?? "Ce sont des entreprises, des individus exerçant légalement des activités dans les domaines de la culture, du tourisme, des services touristiques ayant les mêmes objectifs que l'association." }}</p>
            </div>
            <div class="section-4-1-item">
                <i class="fa-solid fa-arrows-left-right"></i>
                <div class="section-4-1-title">{{ $data['section5_member2_title'] ?? "Membre d'alliance" }}</div>
                <hr>
                <p>{{ $data['section5_member2_content'] ?? "Ce sont des organisations, des entités, des associations ayant des activités directement liées à la culture, au tourisme, partageant les mêmes objectifs que l'association." }}</p>
            </div>
            <div class="section-4-1-item">
                <i class="fa-solid fa-id-card"></i>
                <div class="section-4-1-title">{{ $data['section5_member3_title'] ?? "Membre d'honneur" }}</div>
                <hr>
                <p>{{ $data['section5_member3_content'] ?? "Individus, entités, organisations ayant contribué au développement de l'association et invités en tant que membres honoraires." }}</p>
            </div>
            <div class="section-4-1-item">
                <i class="fa-solid fa-dollar-sign"></i>
                <div class="section-4-1-title">{{ $data['section5_member4_title'] ?? "Membre bienfaiteur" }}</div>
                <hr>
                <p>{{ $data['section5_member4_content'] ?? "Individus, entités et organisations ayant apporté des contributions exceptionnelles au développement de l'association." }}</p>
            </div>
        </div>
    </div>

    
</div>

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
        }
        @media screen and (max-width:768px ) {
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