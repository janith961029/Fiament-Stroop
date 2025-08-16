<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{

    protected $table = 'items';
      protected $guarded = [];
 

  


    
    public function serial_numbers()
    {
        return $this->hasMany(serial_numbers::class);
       
    }
  
public function signalUnit()
{
    return $this->belongsTo(SignalUnit::class, 'signal_unit', 'id');
}
    
    public function equipment_types()
    {
        return $this->belongsTo(equipment_types::class,'equipment_types_id');
       
    }
    public function titlenames()
    {
        return $this->belongsTo(titlenames::class,'title_names_id');
       
    }
    public function item_details()
    {
        return $this->hasMany(ReciveItems::class);
       
    }
   protected $casts = [
    'recieved' => 'array',
];

}