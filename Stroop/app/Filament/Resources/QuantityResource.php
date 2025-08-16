<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuantityResource\Pages;
use App\Filament\Resources\QuantityResource\RelationManagers;
use App\Models\Quantities;
use ArielMejiaDev\FilamentPrintable\Actions\PrintBulkAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuantityResource extends Resource
{
    protected static ?string $model = Quantities::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('item_name')
                ->label('Item Name')
                ->required(),

            Forms\Components\TextInput::make('quantity')
                ->label('Quantity')
                ->numeric()
                ->required(),

            Forms\Components\TagsInput::make('tags')
                ->label('Tags')
                ->suggestions(['recieved', 'Issued'])
        ]);
}

   

    

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuantities::route('/'),
           'create' => Pages\CreateQuantity::route('/create'),
           // 'edit' => Pages\EditQuantity::route('/{record}/edit'),
        ];
    }
}
