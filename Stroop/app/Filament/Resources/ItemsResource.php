<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemsResource\Pages;
use App\Filament\Resources\ItemsResource\RelationManagers;
use ArielMejiaDev\FilamentPrintable\Actions\PrintAction;
use ArielMejiaDev\FilamentPrintable\Actions\PrintBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\FontFamily;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms;
use App\Models\countries;
use Filament\Tables\Actions\Action;
use Filament\Tables;
use App\Models\ictcategories;
use App\Models\titlenames;
use App\Models\stores;
use App\Models\measures;
use App\Models\Items;
use App\Models\equipment_types;


class ItemsResource extends Resource
{
    protected static ?string $model =Items::class;
    protected static ?string $modelLabel='Items';


   // protected static ?string $navigationIcon = 'heroicon-o-rectangle-group'; 


   //public static function getNavigationBadge(): ?string
  //{
//   return static::getModel()::whereNull('total_quantity')
//     ->orWhere('total_quantity', '')
//       ->count();
//}

    protected static ?string $navigationGroup= 'Items';
    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'item_code';
    
   

//public static function mutateFormDataBeforeCreate(array $data): array
//{
   // $lastId = Items::max('id') ?? 0;
   // $nextId = $lastId + 1;

//    $data['item_code'] = 'ITEM-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
//
   // return $data;
//}
    public static function form(Form $form): Form
    {
        
    return $form->schema([
        
        Section::make('General Info')
            ->description('Basic item details')
            ->schema([
                TextInput::make('item_code')
                    ->label('Item Code')
                     ->disabled()
                    ->dehydrated(),
//Relevant Store
                Select::make('relevant_store_id')
                    ->options(stores::pluck('stores', 'id'))
                    ->label('Relevant Store')
                    ->live() 
                    ->required()
                    ->reactive()
                ->afterStateUpdated(fn (Forms\Set $set) => $set('title_name', null)),
//ICT Category
                Select::make('ict_category_id')
                    ->label('ICT Category')
                    ->options(ictcategories::pluck('ictcategories_name', 'id'))
                    ->searchable()
                    ->required(),

//Equipment Type   
                Select::make('equipment_types_id')
                    ->label('Equipment Type')
                    ->options(equipment_types::pluck('equipment_name', 'id'))
                    ->searchable()
                    ->required(),

//Title Name
                Select::make('title_names_id')
                    ->label('Title Name')
                    ->options(titlenames::pluck('title_name', 'id'))
                    ->placeholder(fn(Forms\Get $get) =>
                       empty($get('relevant_store_id'))
                        ? 'First select Store'
                        : 'Select Title Name'
                    )
                ->options(fn (Forms\Get $get) => 
                    titlenames::where('relevant_store_id', $get('relevant_store_id'))
                        ->pluck('title_name', 'title_name'))
                ->required(),

                    
                TextInput::make('item_name')
                    ->label('Item Name')
                    ->required(),
                
                
            ])
            ->columns(2),

        Section::make('Availability')

       
            ->schema([
                Toggle::make('is_serial')
                  ->label('Serial Number..?')
                  ->required(),
                Toggle::make('is_unit')
                  ->label('is_Unit..?')
                  ->required(),
        
            ])
                  ->collapsible()
                  ->columns(1),
       
        Section::make('Inventory Details')
            ->schema([
                Select::make('unit_of_issue_id')
                    ->label('Unit Of Issue')
                    ->options(measures::pluck('measures_name', 'id'))
                    ->searchable()->required()
                    ->required(),


        //Re-Order Level            
                TextInput::make('re_order_level')
                  ->label('Re Order Level')
                
                  ->required(),

        //Commander Reserve        
                TextInput::make('commander_reserve')
                  ->label('Commander Reserve')
               
                  ->required(),
        //Remarks
                TextInput::make('remarks')
                  ->label('Remarks')
                 
                  ->required(),
            ])
            ->columns(2),
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
            ->fontFamily(FontFamily::Mono), 
        Tables\Columns\TextColumn::make('item_code')
            ->label('Item Code')
            ->searchable(isIndividual:true,isGlobal:false)
            ->size('xs')
            ->weight(FontWeight::Light)             
            ->fontFamily(FontFamily::Sans),

        Tables\Columns\TextColumn::make('item_name')
            ->label('Item Name')
            ->size('xs')
            ->weight(FontWeight::Light)             
            ->fontFamily(FontFamily::Sans)
            ->searchable(isIndividual:true,isGlobal:false)
            ->toggleable(isToggledHiddenByDefault:false),

        Tables\Columns\TextColumn::make('equipment_types.equipment_name')
            ->label('Equipment Type')
            ->size('xs')
            ->weight(FontWeight::Light)             
            ->fontFamily(FontFamily::Sans)
            ->searchable(isIndividual:true,isGlobal:false)
            ->toggleable(isToggledHiddenByDefault:true),

        Tables\Columns\TextColumn::make('title_names_id')
             ->label('Title Name')
             ->size('xs')
             ->weight(FontWeight::Light)             
             ->fontFamily(FontFamily::Sans)
             ->searchable(isIndividual:true,isGlobal:false)
             ->toggleable(isToggledHiddenByDefault:true),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
                      
                
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                
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
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItems::route('/create'),
            'view' => Pages\ViewItems::route('/{record}'),
            'edit' => Pages\EditItems::route('/{record}/edit'),
        ];
    }
}
