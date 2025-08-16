<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseOrderNosResource\Pages;
use App\Filament\Resources\PurchaseOrderNosResource\RelationManagers;
use App\Models\PurchaseOrderNos;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\FontFamily;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PurchaseOrderNosResource extends Resource
{
    protected static ?string $model = PurchaseOrderNos::class;
    protected static ?string $modelLabel='Purchase Orders';
    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
           ->columns([
            Tables\Columns\TextColumn::make('id')
            ->label('#')
            ->sortable()
            ->size('sm')
            ->weight(FontWeight::Light) 
            ->toggleable()
            ->Searchable()
            ->fontFamily(FontFamily::Sans), 
            Tables\Columns\TextColumn::make('purchase_order_no')
            ->label('Item Name')
            ->sortable()
            ->size('sm')
            ->weight(FontWeight::Light)             // lighter font
            ->fontFamily(FontFamily::Sans), 
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseOrderNos::route('/'),
            'create' => Pages\CreatePurchaseOrderNos::route('/create'),
            'edit' => Pages\EditPurchaseOrderNos::route('/{record}/edit'),
        ];
    }
}
