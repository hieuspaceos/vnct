<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usernewsletter extends Model
{
    use HasFactory;
    protected $table = 'usernewsletters';
     protected $fillable = [
        'email',
        'phone'        
    ];
}
