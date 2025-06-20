<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReciveItemsResource\Pages;
use App\Filament\Resources\ReciveItemsResource\RelationManagers;
use App\Models\ReciveItems;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\FontFamily;
use Filament\Forms\Components\Toggle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\ictcategories;
use App\Models\titlenames;
use App\Models\stores;
use App\Models\measures;
use App\Models\Items;
use App\Models\equipment_types;

class ReciveItemsResource extends Resource
{
    protected static ?string $model = ReciveItems::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-end-on-rectangle';

    public static function form(Form $form): Form
    {
         return $form->schema([
        Section::make('General Info')
            ->description('Basic item details')
            ->schema([

                //Relevant Store
                Select::make('relevant_store_id')
                    ->options(stores::pluck('stores', 'stores'))
                    ->label('Relevant Store')
                    ->searchable()->required(),

                //ICT Category
                Select::make('ict_category_id')
                    ->label('ICT Category')
                    ->options(ictcategories::pluck('ictcategories_name', 'ictcategories_name'))
                    ->searchable()->required(),

                //Equipment Type   
                Select::make('equipment_type_id')
                    ->label('Equipment Type')
                    ->options(equipment_types::pluck('equipment_name', 'equipment_name'))
                    ->searchable()->required(),

                //Title Name
                Select::make('title_name')
                    ->label('Title Name')
                    ->options(titlenames::pluck('title_name', 'title_name'))
                    ->searchable()->required(),
                TextInput::make('')
                    ->label('Item Code'),
                TextInput::make('')
                    ->label('Ledger Card'),
                TextInput::make('ledger_card_no')
                ->label('Quantity'),
                TextInput::make('manufactured_country')
                    ->label('Country'),
            ])
            ->columns(2),

        Section::make('Availability')

        //is_Unit?  Serial Number Available?
            ->schema([
                Toggle::make('is_serial')
                  ->label('Serial Number..?'),
                Toggle::make('is_unit')
                  ->label('is_Unit..?'),
               


        //serial_numbers
       // Repeater::make('serial_numbers')
               // ->schema([
           //             TextInput::make('name')->required(),
           //             TextInput::make('serial_number')->required(),
           //     ])
            //        ->columns(2)
            //        ->visible(fn ($get) => $get('Serial Number Available?')),
            ])
            ->collapsible()
            ->columns(1),
        //Inventory Details
        Section::make('Inventory Details')
            ->schema([
                Select::make('unit_of_issue_id')
                    ->label('Unit Of Issue')
                    ->options(measures::pluck('measures_name', 'id'))
                    ->searchable()->required(),


        //Re-Order Level            
                TextInput::make('re_order_level')
                  ->label('Re Order Level'),

        //Commander Reserve        
                TextInput::make('commander_reserve')
                  ->label('Commander Reserve'),
        //Remarks
                TextInput::make('remarks')
                  ->label('Remarks'),
            ])
            ->columns(2),
    ]);
}
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListReciveItems::route('/'),
            'create' => Pages\CreateReciveItems::route('/create'),
            'edit' => Pages\EditReciveItems::route('/{record}/edit'),
        ];
    }
}
