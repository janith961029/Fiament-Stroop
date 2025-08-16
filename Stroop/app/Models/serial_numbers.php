<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class serial_numbers extends Model
{
    protected $guarded = [];
   public function item()
{
    return $this->belongsTo(Items::class, 'items_id'); // foreign key = items.id
}


protected $casts = [
    'tags' => 'array',
];
public function signalUnit()
{
    return $this->belongsTo(SignalUnit::class, 'signal_unit', 'id');
}
    public function issuePlace()
    {
        return $this->belongsTo(IssuePlaces::class, 'issue_place');
    }
public function recive_item()
{
    return $this->belongsTo(\App\Models\ReciveItems::class, 'recive_items_id', 'id');
}
}
