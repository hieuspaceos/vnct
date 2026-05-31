<?php
$json_file = public_path('template/files/membres_2.json');

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
 <h1 class="title_h1 h3 text-center mb-4 color-blue d-none"><?=$terms->Name?></h1>
<ul class="nav nav-tabs members" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home_member" type="button" role="tab" aria-controls="home" aria-selected="true"><?=$data_intro["tab1_title"]?></button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false"><?=$data_intro["tab2_title"]?> </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false"><?=$data_intro["tab3_title"]?> </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="contact-tab4" data-toggle="tab" data-target="#contact4" type="button" role="tab" aria-controls="contact4" aria-selected="false"><?=$data_intro["tab4_title"]?> </button>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home_member" role="tabpanel" aria-labelledby="home-tab">
    <?=$data_intro["tab1_content"]?>

  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
      <?=$data_intro["tab2_content"]?>
   

  </div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
      <?=$data_intro["tab3_content"]?>
  </div>
  <div class="tab-pane fade" id="contact4" role="tabpanel" aria-labelledby="contact-tab4">
     <?=$data_intro["tab4_content"]?>
  </div>
</div>
    <div class="container connect my-4">
                <div class="connect-content">
                    <h2><?=$data_intro["support_title"]?></h2>
                    <a href="<?=$data_intro["support_link"]?>">
                        <button class="btn btn-outline-primary btn-sm custom-load-more"><?=$data_intro["support_button"]?></button>
                    </a>
                </div>
            </div>
    



@push('css')
<style type="text/css">
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
    background-color: var(--active-yellow);
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    border-radius: 2px;
}
</style>
@endpush