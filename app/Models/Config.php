<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\where_language;
class Config extends Model
{
    use HasFactory;
    protected $fillable = [
    		'Value',
    		'TieuDe',
    		'Type',
    		'Page',
            'define',
    		'lang',
            'origin_id'
    		
    ];
     protected static function booted()
    {
        static::addGlobalScope(new where_language());
    }
}
