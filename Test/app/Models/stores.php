<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class stores extends Model
{  protected $table = 'stores';
protected $fillable = [

    'id',
    'stores',
    'created_at',
    'updated_at',
    
    ];

}
