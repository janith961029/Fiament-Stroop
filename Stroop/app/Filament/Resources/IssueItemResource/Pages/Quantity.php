<?php

namespace App\Filament\Resources\IssueItemResource\Pages;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use App\Exports\IssuedSerialNumbersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Filament\Resources\IssueItemResource;
use App\Models\serial_numbers;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use Milon\Barcode\Facades\DNS1DFacade as DNS1D;
class Quantity extends Page
{
    protected static string $resource = IssueItemResource::class;

    protected static string $view = 'filament.resources.issue-item-resource.pages.quantity';
     use InteractsWithRecord;

     public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

   public function getViewData(): array
{
  
    $itemid = $this->record->items_id ; // <-- Fix

    // 1) Total serial numbers count
 $totalCount = DB::table('items')
    ->join('recive_items', 'items.id', '=', 'recive_items.items_id')
    ->join('serial_numbers', 'recive_items.id', '=', 'serial_numbers.recive_items_id')
    ->where('items.id', $itemid)   // filter by specific item
    ->count('serial_numbers.id');  // serial_numbers count එක

    // 2) Received count where recieved = 1
    $receivedCount = DB::table('items')
    ->join('recive_items', 'items.id', '=', 'recive_items.items_id')
    ->join('serial_numbers', 'recive_items.id', '=', 'serial_numbers.recive_items_id')
    ->where('items.id', $itemid)      // filter by item_id
    ->where('serial_numbers.recieved', 1) // only received = 1
    ->count('serial_numbers.id');       // count of serial_numbers

    // 3) Issued count where issued = 1
    $issuedCount = DB::table('items')
    ->join('recive_items', 'items.id', '=', 'recive_items.items_id')
    ->join('serial_numbers', 'recive_items.id', '=', 'serial_numbers.recive_items_id')
    ->where('items.id', $itemid)      // filter by item_id
    ->where('serial_numbers.issued', 1) // only received = 1
    ->count('serial_numbers.id');       // count of serial_numbers

   $serialNumbers = DB::table('serial_numbers as sn')
    ->leftJoin('recive_items as i', 'sn.recive_items_id', '=', 'i.id')
      ->leftJoin('signal_units as su', 'sn.signal_unit', '=', 'su.id')
      ->leftJoin('issue_places as ip', 'sn.issue_place', '=', 'ip.id')
       ->where('sn.recive_items_id', $this->record->id)
       ->select(
         'sn.serial_number',
          'sn.recieved',
           'sn.issued',
          'su.sig_unit_name as signal_unit_name',
           'ip.issue_place as issue_place_name',
          // 'i.item_name as item_name',
           'i.warrenty_expiry_date as warranty_expiry_date'
       )
        ->get();

    return [
        'totalCount'    => $totalCount,
        'receivedCount' => $receivedCount,
        'issuedCount'   => $issuedCount,
        'totalCounts'   => DB::table('serial_numbers')->where('recive_items_id', $itemid)->count(),
        'serialNumbers' => $serialNumbers,
    ];
}
   public function exportIssuedSerialNumbers()
{
    $itemId = $this->record->id;
    return Excel::download(new IssuedSerialNumbersExport($itemId), 'issued_serial_numbers.xlsx');
}


}
