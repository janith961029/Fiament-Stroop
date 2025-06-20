<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ictcategories extends Model
{
protected $table = 'ictcategories';
protected $fillable = [

    'id',
    'name',
    'created_at',
    'updated_at',
    ];
}
