<footer class="custom-footer mt-5">
    <div class="container py-5">
        <div class="row">

            <div class="col-lg-4 col-md-6 mb-4 footer-col-info">
                <div class="footer-logo mb-3">
                  <img src="/template/image/vnct-logo.png" width="150">
                </div>
                
                
                
                
                <p class="footer-info-item mt-3 mb-2 font-weight-bold"><?=df116?></p>
                <p class="footer-contact-item">
                    <i class="fas fa-map-marker-alt"></i> <?=df23?>
                </p>
                
               
                
                <p class="footer-contact-item">
                    <i class="fas fa-envelope"></i> <a href="mailto:info@vnct.org">info@vnct.org</a>
                </p>
            </div>

            <div class="col-lg-5 col-md-6 mb-4">
                <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fvnctorg%2F&tabs=timeline&width=340&height=300&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=1500425870286178" width="340" height="300" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
            </div>

            

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="footer-col-heading"><?=df110?></h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="<?=df112?>"><?=df111?></a></li>
                    <li><a href="<?=df114?>"><?=df113?></a></li>
                </ul>
            </div>

        </div>
    </div>
</footer>


<script type="text/javascript" src="/template/js/jquery.js"></script>
<script type="text/javascript" src="/template/js/popper.js"></script>
<script type="text/javascript" src="/template/js/bootstrap.js"></script>
<script type="text/javascript" src="/template/js/fancy.js"></script>
<script type="text/javascript" src="/template/js/owl.js"></script>
<script type="text/javascript" src="/template/js/owl.carousel2.thumbs.js" ></script>
<script type="text/javascript" src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/fancybox/fancybox.umd.js"></script>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(){ AOS.init(); });
  $.ajaxSetup({

    headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

    }

});
</script>


