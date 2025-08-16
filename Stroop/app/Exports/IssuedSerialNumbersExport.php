<?php

namespace App\Exports;

use App\Models\SerialNumber;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class IssuedSerialNumbersExport implements FromCollection, WithHeadings
{
    protected $itemId;

    public function __construct($itemId)
    {
        $this->itemId = $itemId;
    }

    public function collection()
    {
        return DB::table('serial_numbers as sn')
           ->leftJoin('items as i', 'sn.items_id', '=', 'i.id')
           ->leftJoin('signal_units as su', 'sn.signal_unit', '=', 'su.id')
           ->leftJoin('issue_places as ip', 'sn.issue_place', '=', 'ip.id')
            ->where('sn.items_id', $this->itemId)
            ->where('sn.issued', 1)
            ->select(
                  'sn.serial_number',
        
        'i.item_Type as item_name',
        'su.sig_unit_name as signal_unit_name',
        'ip.issue_place as issue_place_name',
        
        'i.warrenty_expiry_date as warranty_expiry_date'
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'Serial Number',
            'Item Name',
            'Signal Unit',
            'Issue Place',
             'Warrenty Expiry Date',
        ];
    }
}
