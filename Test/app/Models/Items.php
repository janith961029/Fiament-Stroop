<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{

    protected $table = 'items';
    protected $fillable = [

    'id',
    'relevant_store_id',
    'ict_category_id',
    'equipment_type_id',
    'title_name',
    'item_name',
    'ledger_card_no',
    'manufactured_country',
    'is_serial',
    'is_unit',
    'unit_of_issue_id',    
    're_order_level',
    'commander_reserve',
    'remarks',
    'created_at',
    'updated_at',
 

    
    ];


      public function stores()
    {
        return $this->belongsTo(items::class, 'relevent_store_id');
    }
     public function ictcategories()
    {
        return $this->belongsTo(items::class, 'ict_category_id');
    }
    public function equipment_types()
    {
        return $this->belongsTo(items::class, 'equipment_type_id');
    }
   public function Ledger()
    {
        return $this->belongsTo(items::class, 'ledger_card_no');
    }
   public function reorderLvl()
    {
        return $this->belongsTo(items::class, 're_order_level');
    }
    public function comdresv()
    {
        return $this->belongsTo(items::class, 'commander_reserve');
    }








}