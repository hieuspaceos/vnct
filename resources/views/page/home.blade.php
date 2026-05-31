@extends('index')

@section('banner')	

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

    <!-- INDICATORS -->
    <ol class="carousel-indicators">
        @php 
        $slides = json_decode(df7 ?? '[]', true);
        $slideNum = 0; 
        @endphp
        @for($i = 0; $i < count($slides); $i += 3)
            @php
                $active = $slideNum == 0 ? 'active' : '';
            @endphp
            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $slideNum }}" class="{{ $active }}"></li>
            @php $slideNum++; @endphp
        @endfor
    </ol>

    <!-- SLIDER ITEMS -->
    <div class="carousel-inner">
        @php $slideNum = 0; @endphp

        @for($i = 0; $i < count($slides); $i += 3)
            @php
                $url = $slides[$i] ?? '#';
                $image = $slides[$i+1] ?? '/template/admin/image/noimage.jpg';
                $content = $slides[$i+2] ?? '';

                $active = $slideNum == 0 ? 'active' : '';
            @endphp

            <div class="carousel-item {{ $active }}">
                
                <img src="{{ env('APP_URL') . $image }}" 
                     class="d-block w-100 carousel-img-custom" 
                     alt="Slide {{ $slideNum + 1 }}">

                <!-- Vùng content -->
               
                    {!! $content !!}

                   
                
            </div>

            @php $slideNum++; @endphp
        @endfor
    </div>

    <!-- BUTTON NEXT / PREV -->
    <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="sr-only">Previous</span>
    </button>

    <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators" data-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="sr-only">Next</span>
    </button>

</div>

@endsection
@section('content')	
	       <?=df100?>
	   

	    {{-- Tin tức --}}

		    <div class="container event-news-grid my-5">
	    
			    <h2 class="section-title-large mb-4"><?=$name_tt?></h2>
			    
			    <div class="row">
			    	@foreach($tt as $v)
			        <div class="col-12 col-md-6 col-lg-4 mb-4">
			            <div class="event-post-card">
			                 <a href="<?=$v->Post_Name?>.html"><img src="<?=$v->Post_Thumb?>" class="img-fluid post-thumb" alt="<?=$v->Post_Title?>"></a>
			                <div class="post-content">
			                    <h5 class="post-title">
			                        <a href="<?=$v->Post_Name?>.html"><?=$v->Post_Title?></a>
			                    </h5>
			                    <p class="post-source">
			                         <?=$v->Terms[0]->Name?> <span class="text-muted small"> •   {{ $v->updated_at->format('d/m/Y') }}</span>
			                    </p>
			                </div>
			            </div>
			        </div>
			        
			       	@endforeach

			        
			    </div>
			    
			    <div class="text-center mt-3">
			        <a href="<?=$tt_term->Slug?>" class="btn btn-outline-primary btn-sm custom-load-more"><?=df119?></a>
			    </div>
			</div>
			<div class="container connect">
				<div class="connect-content">
					<h2><?=df118?></h2>
					<a href="<?=df120?>">
						<button class="btn btn-outline-primary btn-sm custom-load-more"><?=df119?></button>
					</a>
				</div>
			</div>
			<div class="container event-history-section my-5">
    
			    <h2 class="section-title-large mb-4"><?=$name_event?></h2>
			    <div class="col-12">
				    <div class="owl-carousel owl-theme" id="evento">
				        @foreach($event as $v)
				        
				            <div class="event-card-4-col">
				                <a href="<?=$v->Post_Name?>.html"><img src="<?=$v->Post_Thumb?>" class="img-fluid card-img-top" alt="<?=$v->Post_Title?>"> </a>
				                <div class="card-body-content">
				                    <h5 class="event-title">
				                        <a href="<?=$v->Post_Name?>.html"><?=$v->Post_Title?></a>
				                    </h5>
				                    <p class="event-meta">
				                         <?=$v->Terms[0]->Name?> <span class="text-muted small"> • {{ $v->updated_at->format('d/m/Y') }}</span>
				                    </p>
				                </div>
				            </div>
				        
				        @endforeach
				    </div>
			  	</div>
			</div>
			
			<div class="container data-media-section my-5">
		    <h2 class="section-title-large mb-4"><?=df121?></h2>
		    <div class="owl-carousel owl-theme" id="video">
		    		@php 
			        $slides = json_decode(df104 ?? '[]', true);			       
			        @endphp
		    		@for($i = 0; $i < count($slides); $i += 3)
		        <div class="item" data-video="{{ $slides[$i]}}">
		            <div class="media-card-3-col">
		                <div class="media-thumbnail video-thumb">
		                    <img src="{{ $slides[$i+1]}}" class="img-fluid card-img-top" alt="Chùa Một Cột">
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
<!-- Modal Video -->
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
	    	  


@endsection
@push('css')
<style type="text/css">

</style>
@endpush
@push('js')

<script type="text/javascript">
	$(document).ready(function () {

    // Click vào thumbnail để mở popup
    $('#video .video-thumb').on('click', function () {
    let videoUrl = $(this).closest('.item').data('video');

    if (videoUrl) {
        // Cách 1: Dùng URL API để parse đúng
        try {
            let url = new URL(videoUrl);
            let videoId = url.searchParams.get('v');
            
            if (videoId) {
                let embedUrl = `https://www.youtube.com/embed/${videoId}`;
                $("#videoFrame").attr("src", embedUrl + "?autoplay=1");
                $("#videoModal").modal("show");
            }
        } catch (e) {
            console.error("URL không hợp lệ:", e);
        }
    }
});
    // Khi đóng modal thì dừng video
    $('#videoModal').on('hidden.bs.modal', function () {
        $("#videoFrame").attr("src", "");
    });

});
	$(document).ready(function() {
    // Hàm để kích hoạt animation
    {{-- function animateCarouselCaption(carouselItem) {
        carouselItem.find('[data-animation]').each(function() {
            var $this = $(this);
            var delay = $this.data('delay') || '0s'; // Lấy giá trị delay từ data-delay
            
            // Xóa class animation cũ trước khi thêm lại để animation chạy lại
            $this.removeClass('is-visible'); 
            
            setTimeout(function() {
                $this.addClass('is-visible');
            }, parseFloat(delay) * 1000); // Chuyển delay từ giây sang mili giây
        });
    }

    // Khởi tạo animation cho item active ban đầu
    animateCarouselCaption($('#carouselExampleIndicators .carousel-item.active'));

    // Bắt sự kiện khi carousel chuyển slide
    $('#carouselExampleIndicators').on('slide.bs.carousel', function () {
        // Reset tất cả các animation khi slide bắt đầu chuyển
        $(this).find('.carousel-item [data-animation]').removeClass('is-visible');
    });

    $('#carouselExampleIndicators').on('slid.bs.carousel', function () {
        // Kích hoạt animation cho item active mới
        var $activeItem = $(this).find('.carousel-item.active');
        animateCarouselCaption($activeItem);
    }); --}}
});
$(document).ready(function() {
		$('#evento').owlCarousel({
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
		            items:4,
		            nav:false,
		            loop:false
		        }
		    }
		});
		$('#video').owlCarousel({
		    loop:true,
		    margin:10,
		    items:1,

		});
    // 1. Lấy phần tử Sidebar
   
});
</script>
@endpush