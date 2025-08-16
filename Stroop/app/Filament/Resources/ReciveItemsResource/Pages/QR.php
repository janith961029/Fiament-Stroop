<?php

namespace App\Filament\Resources\ReciveItemsResource\Pages;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use App\Filament\Resources\ReciveItemsResource;
use Filament\Resources\Pages\Page;
use App\Models\serial_numbers;
class QR extends Page
{
    protected static string $resource = ReciveItemsResource::class;

    protected static string $view = 'filament.resources.recive-items-resource.pages.q-r';

   use InteractsWithRecord;

     public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }
   
}
