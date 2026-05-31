
@extends('index')
@section('content')
<div class="section_1">
	
	<div class="row">
		{{-- @include('blocks.breadcrumb-trangloai') --}}
	</div>
	<?php
			if(count($sub_cate)==0)
			{
				echo '<h1 class="title_h1 h3 text-center mb-3 color-blue">'.$terms->Name.'</h1>';
				echo $terms->Content;
				echo '<div class="row">';
				foreach($posts as $v)
				{
					echo '<div class="col-12 col-md-6 col-lg-4 mb-4">';
					echo \App\Helpers\Helper::template_tintuc($v);
					echo '</div>';
				}
				echo '</div>';


				echo '<div class="d-flex justify-content-center mt-5">
				    '.$posts->links().'
				</div>';
			}
			else
			{
				echo '<h1 class="title_h1 h3 text-center mb-3 color-blue">'.$terms->Name.'</h1>';
				echo $terms->Content;
				echo '<div class="row">';
				foreach($posts as $v)
				{
					echo '<div class="col-12 col-md-6 col-lg-4 mb-4">';
					echo \App\Helpers\Helper::template_tintuc($v);
					echo '</div>';
				}
				echo '</div>';


				echo '<div class="d-flex justify-content-center mt-5">
				    '.$posts->links().'
				</div>';
				foreach($sub_cate as $v)
				{
					echo '<div class="list-posts" data-id="'.$v->id.'" data-name="'.$v->Name.'"></div>';
				}
				// foreach($sub_cate as $v)
				// {
				// 	$kqs = \App\Models\Posts::Wherehas('Terms',function($query) use($v){
                //     	$query->where("id",$v["id"]);
            	// 	})->where('Post_Status',1)->orderByDesc('created_at')->paginate(12);
            	// 	//dd($post);
            	// 	if(count($kqs) > 0)
            	// 	{
	            // 		echo '<h2 class="title_h1 text-center mb-3">'.$v->Name.'</h2>';
	            // 		foreach ($kqs as $kq) {
	            // 			echo '<div class="col-12 col-md-6 col-lg-4 mb-4">';
				// 			echo \App\Helpers\Helper::template_tintuc($kq);
				// 			echo '</div>';
	            // 		}
            	// 	}
				// }
			}
			?>
		
	
</div>
	
@endsection
@section('css')
<style type="text/css">
	
</style>
@endsection
@push('js')
<script>
document.addEventListener('DOMContentLoaded', async function() {
    const listEls = $(".list-posts").toArray();

    // chạy tuần tự từng phần tử
    for (const el of listEls) {
        const $el = $(el);
        const id = $el.data("id");
        const name = $el.data("name");
        await fetchPosts($el, id, name, 1);
    }
});

async function fetchPosts($container, id, name, page = 1) {
    try {
        const res = await fetch(`/ajax/load-posts?cate=${id}&name=${encodeURIComponent(name)}&page=${page}`);
        const data = await res.json();

        if (page === 1) {
            // lần đầu load
            $container.html(data.html);
        } else {
            // append thêm
            $container.find('.load-more').remove();
            $container.append(data.html);
        }

        if (data.hasMore) {
            const $btn = $(`<div class="col-12 text-center load-more my-3">
                <button class="btn btn-outline-primary btn-sm custom-load-more"><?=df119?></button>
            </div>`);
            $container.append($btn);

            $btn.find('button').on('click', function() {
                fetchPosts($container, id, name, data.nextPage);
            });
        }

    } catch (err) {
        console.error(err);
    }
}

</script>
@endpush