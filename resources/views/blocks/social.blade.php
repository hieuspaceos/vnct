<div class="social-fixed ">
	@if (df16!="")
                
                <div> <a href="{{ df16 }}" > <i class="fa-brands color_vang fa-2x fa-square-facebook"></i></a></div>

                @endif

                @if (df17)

                 <div><a href="{{ df17 }}"> <i class="fa-brands color_vang fa-2x fa-square-instagram"></i></a></div>

                @endif   

               

                @if (df24!="")

                 <div><a href="{{ df24 }}" > <img style="    width: 30px;
    height: 30px;
    max-width: fit-content;" class="icon-social" src="/template/image/icons8-zalo.png"></a></div>

                @endif
                @if (df25!="")

                <div> <a href="{{ df25 }}" > <i class="fa-brands color_vang fa-2x fa-facebook-messenger"></i></a></div>

                @endif 

                @if (df2!="")

                <div> <a href="tel:<?=str_replace(['.',',',' '], '', df2)?>" > <i class=" color_vang fa-2x fa-solid fa-square-phone"></i></a></div>

                @endif  
</div>
