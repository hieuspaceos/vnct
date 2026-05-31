<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\where_language;
class Posts extends Model
{
    use HasFactory;
    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [    		
    		'users_id',
            'Post_Title',
            'Post_Status',
            'Post_Name',
    		'Post_Thumb',    		
    		'Price',
            'Listed_Price',
    		'Sale',
    		'View',  
            'Short_Post_Content',  		    	
            'Post_Content',
            'Post_Sizing',
            'Post_Returns',
            'Post_Shiping',
    		'Title',
    		'Desription',
    		'Keyword',
            'Post_Type',
    		'lang',
            'origin_id',
            'brands_id'        
    ];
    public function Terms()
    {
        return $this->belongsToMany('App\Models\Terms','terms_posts');
    }  
    public function Color()
    {
        return $this->belongsToMany('App\Models\Color','product_color_size','posts_id','colors_id')
        ->withPivot('sizes_id','album','soluong','price','price_sale');
    }
    
    public function Size()
    {
        return $this->belongsToMany('App\Models\Size','product_color_size','posts_id','sizes_id')
        ->withPivot('colors_id', 'album','soluong','price','price_sale');
    }
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->withoutGlobalScope(\App\Scopes\where_language::class)
                    ->where($field ?? $this->getRouteKeyName(), $value)
                    ->first();
    }
    protected static function booted()
    {
        static::addGlobalScope(new where_language());
    }
    public function terms_posts()
    {
        return $this->hasOne('App\Models\terms_posts','posts_id');
    }
    public function Colororder()
    {
        return $this->hasOne('App\Models\product_color_size','posts_id');
    }
    public function scopeOrderbyFilter($query, $request)
    {
        //dd($request->input());        
        if ($request->input("sort")) {
            if($request->input("sort")!="")
            {
                $sort_product = explode(";",$request->input("sort"));
                if($sort_product[1]=="desc")
                {
                    $str = "";
                    if($sort_product[0]==1)
                    {
                       $str = "created_at"; 
                       $query->orderByDesc($str);           
                    }
                    if($sort_product[0]==2)
                    {
                       $str = "View"; 
                       $query->orderByDesc($str);           
                    }
                    if($sort_product[0]==3)
                    {
                       $str = "Price";         
                       $query->orderByRaw("IF (product_color_size.price_sale > 0,product_color_size.price_sale,product_color_size.price) desc");
                    }
                     
                }
                else
                {                             
                    $query->orderByRaw("IF (product_color_size.price_sale > 0,product_color_size.price_sale,product_color_size.price) asc");             
                }   
            }        
        }
        else
        {
            $query->orderByDesc('id'); 
        }
        return $query;
    }
    public function scopeLimitFilter($query, $request)
    {
        //dd($request->input());        
        if ($request->input("sort")) {
            
        }
        
        return $query;
    }
    public function review()
    {
        return $this->hasMany("App\Models\ReviewProduct",'posts_id');
    }


}
