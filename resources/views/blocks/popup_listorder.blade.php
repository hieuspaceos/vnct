<div class="box-show-message"  >	
        <?php 
        $list_popup = App\Models\PopupListBuy::inRandomOrder()->limit(4)->get();
        $array_list_popup = "";
        $dem = 0;
        foreach ($list_popup as $v)
        {
            $dem++;
            if($dem==1)
            {
                $array_list_popup.= $v->id;
            }
            else
            {
                $array_list_popup.= ",".$v->id;
           
            }
            //echo $array_list_popup;
            $productname = App\Models\Posts::find($v->posts_id);
            $album = App\Models\product_color_size::where("posts_id",$v->posts_id)->where("colors_id",$v->colors_id)->limit(0)->first();
                        //dd($album);
            $album =  explode(",", $album->Album);
            $date = Carbon\Carbon::parse($v->updated_at);
            $now = Carbon\Carbon::now();
            $thoigian = $now->diffInMinutes($date);
          // $thoigian =  Carbon\Carbon::now()->diffForHumans($date);
           //dd($thoigian);

            $value = $thoigian * 60;
            $dt = Carbon\Carbon::now();
            $days = $dt->diffInDays($dt->copy()->addSeconds($value));
            $hours = $dt->diffInHours($dt->copy()->addSeconds($value)->subDays($days));
            $minutes = $dt->diffInMinutes($dt->copy()->addSeconds($value)->subDays($days)->subHours($hours));
            $hour = Carbon\CarbonInterval::hours($hours)->forHumans();
             //dd($hour);
            if($hour!="1 second")
            {
               $thoigian =  $hour." ago";
            }
            else
            {
                 $minutes = Carbon\CarbonInterval::minutes($minutes)->forHumans();
                 //dd($minutes);
                 $thoigian =  $minutes." ago"; 
            }

        ?>  
        <div class="content-show-msg list_popup{{ $v->id }}" style="display: none">
		    <div class="close_popup">&#x2715</div>
            <div class="info-show-msg">
               <a class="color_vang " href="/{{ $productname->Post_Name }}.html?color={{$v->colors_id  }}" ><img src="{{ $album[0] }}" class="change-image-avatar"></a>
            </div>
            <div class="show-msg">
                    <div class="nttitle" style="font-size: 70%;">{{ $v->Content }}</div>
                    <div class="mt-1" style="    flex-grow: 1;"><a class="color_vang title_list_order" href="/{{ $productname->Post_Name }}.html?color={{$v->colors_id  }}" >
                        {{ $productname->Post_Title }}
                    </a></div>
                    <div class="nttime mt-2">{{ $thoigian }}</div>
                   
            </div>
        </div>
        <?php } //echo $array_list_popup; ?>
</div>