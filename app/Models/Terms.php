<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\where_language;
class Terms extends Model
{	
    use HasFactory;
    
  /**
   * Fields that can be mass assigned.
   *
   * @var array
   */
  protected $table = 'terms';
  protected $fillable = [
      'id',
  		'Name',
  		'Slug',
  		'Image',
  		'Taxonomy',
  		'Parent',
  		'Title',
  		'Description',
  		'keyword',
  		'Content',
  		'vitri',
  		'ThuTu',
  		'AnHien',
      'lang',
      'origin_id'
  ];
   public function childs() {
    
        return $this->hasMany('App\Models\Terms','Parent','id') ;
    }
     public function parents() {
        return $this->hasMany('App\Models\Terms','id','Parent') ;
    }
    public function Posts()
    {
        return $this->belongsToMany('App\Models\Posts','terms_posts');
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
    
}
