<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Terms;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
      
         view()->composer('*', function ($view) 
        {
          //dd(json_decode(df5));
         //$menucha = Terms::where("Parent",0)->where("vitri",1)->where("Taxonomy","sanpham")->get();         
        // dd(Terms::where("Parent",0)->where("Taxonomy","sanpham")->toSql()); 

                   
         //View::share(['menucha'=> json_decode(df5)]);
          
         Paginator::defaultView('vendor.pagination.bootstrap-4'); 
        });
         // Paginator::defaultSimpleView('vendor.pagination.bootstrap-4');       
    }
}
