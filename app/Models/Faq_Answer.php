<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq_Answer extends Model
{
    use HasFactory;
    protected $table = 'faq__answers';
     protected $fillable = [
     	'Question',
    		'Answer',
    		'faqs_id',    		
    		
    ];
}
