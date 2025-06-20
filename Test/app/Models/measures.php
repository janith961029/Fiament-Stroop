<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class measures extends Model
{
      protected $table = 'measures';
protected $fillable = [

    'id',
    'measures_code',
    'measures_name',
    'created_at',
    'updated_at',
    ];

}
