<?php

namespace App\Filament\Resources\IssueItemResource\Pages;

use App\Filament\Resources\IssueItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIssueItem extends EditRecord
{
    protected static string $resource = IssueItemResource::class;

   // protected function getHeaderActions(): array
   // {
     //   return [
       //     Actions\DeleteAction::make(),
      //  ];
 //   }
protected function afterSave(): void
{
    $commonFields = [
        'assigned_date' => $this->data['assigned_date'] ?? null,
        'issue_place'   => $this->data['issue_place'] ?? null,
        'issuing_type'  => $this->data['issuing_type'] ?? null,
        'job_card_number' => $this->data['job_card_number'] ?? null,
        'signal_unit'   => $this->data['signal_unit'] ?? null,
    ];

    $this->record->serial_numbers()
        ->where('issued', true) // issued කරන එකේට විතර update කරන්න
        ->update($commonFields);
}
}
