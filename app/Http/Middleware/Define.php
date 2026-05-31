<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductLike;
class Define
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
         if(Session::has('language')) {
               App::setLocale(Session::get('language'));
        }
         $config = Config::all()->toArray(); 
         //dd($config);           
            foreach ( $config as $key => $value) {
               define("df".$value["define"],$value["Value"]);
         }
        //  $wishlist = array();
        // if(Auth::check())
        // {
        //    $wisthlists =  ProductLike::where("users_id",Auth::user()->id)->get();
        //    foreach ($wisthlists as $key => $value) {
        //        array_push($wishlist, rand(10000,99999).$value->posts_id.rand(1000000,9999999));
        //    }
        //    Session::put('wishlists',$wishlist);
        // }
        
        return $next($request);
    }
}
