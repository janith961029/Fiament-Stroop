<?php

namespace App\Filament\Resources\SerialNumberResource\Pages;

use App\Filament\Resources\SerialNumberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSerialNumber extends EditRecord
{
    protected static string $resource = SerialNumberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
