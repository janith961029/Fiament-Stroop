<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class titlenames extends Model
{
      protected $table = 'titlenames';
protected $fillable = [

    'id',
    'title_no',
    'title_name',
    'store_id',
    'create_date',
    'user_id',
    'modified_date',
    'modified_user_id',
    'created_at',
    'updated_at',
    
    
    ];

}
