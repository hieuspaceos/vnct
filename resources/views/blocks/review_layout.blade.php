<div class="grid-item " onclick="popup_review({{ $v->id }})" >
                          <div id="comment-20" class="comment_container"> 
                             @if ($v->Image!="")
                               <img src="/uploads/review/{{ $v->Image }}" >
                              @endif
                            <div class="comment-text">
                              <p class="meta"> 
                                <strong class="woocommerce-review__author">{{ $v->Name }}</strong> 
                                <span class="woocommerce-review__dash">–</span>
                                <time class="woocommerce-review__published-date" datetime="{{ $v->created_at->format('F d, Y') }}">{{ $v->created_at->format('F d, Y') }}</time>
                              </p>
                              <div class="star-rating">
                                <span style="width: {{ $v->Start * 20 }}%;">Rated <strong class="rating">5</strong> out of 5</span>
                              </div>
                              
                              <div class="description">
                                <p>{{ $v->Content }}</p>
                              </div>
                              <hr>
                              <?php
                                  $product = $v->product;
                                 $color = App\Models\product_color_size::where('posts_id',$product->id)->where('colors_id',$v->colors_id)->limit(1)->get();
                                 $product_img =  explode(",", $color[0]->Album);
                                 //dd($color->toarray());
                              ?>
                              <div class="description">
                                <div class="row">
                                    <div class="col-4">
                                       <img src="{{ $product_img[0] }}" >
                                    </div>
                                    <div class="col-8">
                                        {{ $product->Post_Title }}
                                    </div>
                                </div>
                              </div>
                              
                            </div>
                          </div>
                        </div>
@section('css')
<style type="text/css">
 #comments .woocommerce-Reviews-title{
    font-size: 15px;
    font-weight: 600;
}
#comments .woocommerce-Reviews-title span{
    font-weight: 400;
    font-style: italic;
}
#comments .commentlist{
    padding: 0;
}
#comments .commentlist li{
    list-style: none;
    display: block;
    width: 100%;
  
    margin-bottom: 15px;
}
#comments .commentlist li .comment_container img{
   max-width: 300px;
    max-height: 300px;
}
#comments .commentlist li .comment_container .comment-text{
    
    width: calc( 100% - 80px);
    width: -webkit-calc( 100% - 80px);
    width: -moz-calc( 100% - 80px);
   
}
p.stars::after {
    display: block;
    clear: both;
    content: '';
}
.width-80-percent{
    width: 80%;
}
.star-rating{
    font-size: 0;
    position: relative;
    display: inline-block;
}
@media screen and (-ms-high-contrast: active), (-ms-high-contrast: none) {
    .star-rating{
        overflow: hidden;
    }
}
.star-rating::before{
    content: "\f005\f005\f005\f005\f005";
    font-family: FontAwesome;
    font-size: 15px;
    color: #000;
}
.star-rating span{
    display: inline-block;
    float: left;
    overflow-x: hidden; 
    position: absolute;
    top: 0;
    left: 0;
}

.star-rating span:before{
    content: "\f005\f005\f005\f005\f005";
    font-family: FontAwesome;
    font-size: 15px;
    color: #efce4a;
}
#comments .commentlist li .comment_container .meta{
    margin-bottom: 8px;
}
#review_form_wrapper #review_form{
    display: inline-block;
    width: 100%;
}
#review_form_wrapper #review_form .comment-form p>label{
    display: block;
    font-size: 14px;
    color: #666666;
    font-weight: 400;
}
#review_form_wrapper #review_form .comment-form p.comment-form-author,
#review_form_wrapper #review_form .comment-form p.comment-form-email{
    width: calc(50% - 15px);
    width: -webkit-calc(50% - 15px);
    width: -moz-calc(50% - 15px);
    float: left;
}
#review_form_wrapper #review_form .comment-form p.comment-form-author{
    margin-right: 30px;
}
#review_form_wrapper #review_form .comment-form p.form-submit,
#review_form_wrapper #review_form .comment-form p.comment-form-comment{
    display: inline-block;
    float: left;
    width: 100%;
}
#review_form_wrapper #review_form .comment-form p.form-submit input[type=submit]{
    max-width: 115px;
    border: 0;
    border-radius: 0;
    color: #ffffff;
    text-align: center;
    font-size: 14px;
    line-height: 20px;
    padding: 9px;
    width: 100%;
    margin-bottom: 15px; background: rgba(145,2,32,1);
}
#review_form_wrapper #review_form .comment-form p.form-submit input[type=submit]:hover{
    background-color:#7b051e; cursor:pointer;
}
#review_form_wrapper #review_form .comment-form textarea[name=comment]{
    display: block;
    width: 100%;
    border: 1px solid #e6e6e6;
    outline: none;
    padding: 10px;
    margin-bottom: 17px;
}

#review_form_wrapper #review_form .comment-form p input[type=text],
#review_form_wrapper #review_form .comment-form p input[type=email]{
    display: block;
    width: 100%;
    border: 1px solid #e6e6e6;
    outline: none;
    height: 39px;
    padding: 2px 10px;
    margin-bottom: 17px;
}
.wrap-product-detail .comment-form-rating>span{
    font-size: 14px;
    line-height: 20px;
    display: block;
    float: left;
    margin-right: 7px;
    color: #666;
}
.wrap-product-detail .comment-form-rating ~ p{
    margin-bottom: 0 !important;
}
.wrap-product-detail .comment-form-rating p.stars{
    display: inline-block;
    margin-bottom: 0 !important;
}
.comment-form-rating .stars input[type=radio]{
    display: none;
}
.comment-form{display: none}
.comment-form-rating .stars label{
    display: block;
    float: left;
    margin: 0;
    padding: 0 2px;
}
.comment-form-rating .stars label::before{
    content: "\f005";
    font-family: FontAwesome;
    font-size: 15px;
    /*color: #e6e6e6;*/
    color: #efce4a;
}
.comment-form-rating .stars input[type=radio]:checked ~ label::before{
    color: #e6e6e6 ;
}
.comment-form-rating .stars:hover label::before{
    color: #efce4a !important;
}
.comment-form-rating .stars label:hover ~ label::before{
    color: #e6e6e6 !important;
}
.comment-form-rating{
    margin-bottom: 15px;
}
 p.form-group::before {
    display: block;
    content: '';
    clear: both;
}
.buttonaddreview
{
  border: 1px solid #E8E8E8;
 
    cursor: pointer;
    color: #000000; border-radius: 8px;
    padding: 5px 10px; text-align: center;
    font-family: 'Roboto', sans-serif;
}
.buttonaddreview:hover
{
  background: rgba(145,2,32,1);
  color: #fff;
}
#gallery_review .grid-sizer, #gallery_review .grid-item {
    width: 24%;
    margin: 0.5% 0.5%;
}
#gallery_review .grid-item
{
  float: left;
    border: 5px solid #fff;
       border-radius: 8px; 
    }
.comment_container
{
   box-shadow: 0 0 3px rgb(0 0 0 / 20%);
    background: #fff;
   
}
.comment-text {
    padding: 10px;
}

</style>
@endsection                        
