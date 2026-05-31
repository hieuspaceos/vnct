<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
     protected $fillable = [
    		'Title',
    		'terms_id',
            'thutu',
    		'lang'    	
    ];
    public function Faq_Answer()
    {
    	return $this->hasMany('App\Models\Faq_Answer','faqs_id');
    }
    public function Terms()
    {
    	return $this->belongsTo('App\Models\Terms');
    }
}
