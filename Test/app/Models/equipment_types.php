<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class equipment_types extends Model
{
    protected $table = 'equipment_types';
protected $fillable = [

    'id',
    'type_code',
    'equipment_name',
    'created_at',
    'updated_at',
    ];

}
