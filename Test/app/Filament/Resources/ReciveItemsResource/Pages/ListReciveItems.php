<?php

namespace App\Filament\Resources\ReciveItemsResource\Pages;

use App\Filament\Resources\ReciveItemsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReciveItems extends ListRecords
{
    protected static string $resource = ReciveItemsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
