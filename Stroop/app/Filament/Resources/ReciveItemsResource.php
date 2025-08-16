<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReciveItemsResource\Pages;
use App\Filament\Resources\ReciveItemsResource\RelationManagers;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TagsInput;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\FontFamily;
use App\Models\ReciveItems;
use App\Models\ictcategories;
use App\Models\titlenames;
use App\Models\stores;
use App\Models\measures;
use App\Models\RecPlaces;
use App\Models\PurchaseOrderNos;
use App\Models\Items;
use App\Models\equipment_types;
use App\Models\IssueItem;
use App\Models\LedgerCard;
use App\Models\countries;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\HtmlColumn;
use DNS1D;
class ReciveItemsResource extends Resource
{
    protected static ?string $model =Items::class;
    protected static ?string $modelLabel='Recieved Items';
   
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel= 'Recieved Items';
    protected static ?string $navigationGroup= 'Items';
   
  //public static function getNavigationBadge(): ?string
//{
//    return static::getModel()::whereNotNull('total_quantity')->where('total_quantity', '!=', '')->count();
//}

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Grid::make(3)
                ->schema([
//Relevant Store
                    Forms\Components\Select::make('relevant_store_id')
                        ->options(stores::pluck('stores', 'id'))
                        ->label('Relevant Store')
                        ->disabled()
                        ->searchable()->required(),

//ICT Category
                    Forms\Components\Select::make('ict_category_id')
                        ->label('ICT Category')
                        ->disabled()
                        ->options(ictcategories::pluck('ictcategories_name', 'id'))
                        ->searchable()->required(),

//Equipment Type   
                    Forms\Components\Select::make('equipment_types_id')
                        ->label('Equipment Type')
                        ->disabled()
                        ->options(equipment_types::pluck('equipment_name', 'id'))
                        ->searchable()->required(),

//Title Name
                    Forms\Components\Select::make('title_names_id')
                        ->label('Title Name')
                        ->disabled()
                        ->options(titlenames::pluck('title_name', 'id'))
                        ->searchable()->required(),

                    Forms\Components\TextInput::make('item_code')
                        ->disabled()
                        ->label('Item Code'),

                    

                ])
                ->columns(3),
                
        Section::make('Serial Numbers')
        ->schema([
              // Repeater::make('serial')
                   // ->relationship('serial_numbers', fn (Builder $query) => $query->where('recieved', '0'))
               //   ->relationship('serial_numbers')
               //    ->disableItemDeletion()
                 //   ->schema([
                      //  TextInput::make('name')->required(),
                       // TextInput::make('serial_number')->required(),
                       // TextInput::make('barcode')->required(),
                       // Forms\Components\Toggle::make('recieved')
                          //  ->label('Received')
                            
                        
    //])
                    
                      
                  //  ->reactive()
                  //  ->columns(3)
                   // ->collapsed(false)
                  //  ->collapsible(),
                  
                                    

        
        Repeater::make('Recieving Details')
       ->relationship('item_details', fn (Builder $query) =>$query->whereNull('total_quantity'))
//      ->relationship('item_details')
            ->schema([
                Forms\Components\Select::make('manufactured_country')
                        ->label('Manufactured  Country')
                        ->options(countries::pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                TextInput::make('ledger_card_no')
                ->label('Ledger Card'),


                TextInput::make('total_quantity')
                  ->label('Quantity')
                   
                    ->numeric()
                    ->integer()
                    ->minValue(0)
                    ->step(1)
                    ->rules(['required', 'integer', 'min:0'])
                    ->placeholder('Quantity'),
                Select::make('purchase_order_no')
                    ->label('Purchase Order No')
                    ->options(PurchaseOrderNos::pluck('purchase_order_no', 'id'))
                    ->searchable()->required(),

                TextInput::make('itemprice')
                  ->label('Item Price (LKR)')
                   
                    ->numeric()
                    ->integer()
                    ->minValue(0)
                    ->step(1)
                    ->rules(['required', 'integer', 'min:0'])
                    ->placeholder('PRICE'),
                                        
                Select::make('received_place')
                    ->label('Received From')
                    ->options(RecPlaces::pluck('Rec_place', 'id'))
                    ->searchable()->required(),
       
                DatePicker::make('received_date')
                    ->label('Received Date ')
                    ->required(),
                DatePicker::make('warrenty_expiry_date')
                    ->label('Warranty Expiry Date')
                    ->required(),
               // TextInput::make('commander_reserve')
               //   ->label('Commander Reserve'),
       
                TextInput::make('remarks_recieved')
                  ->label('Remarks'),
            ])
            ->columns(3),
    ])]);
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
                ->sortable()
                ->searchable(isIndividual:true,isGlobal:false)
                ->size('xs')
                ->weight(FontWeight::Light)             
                ->fontFamily(FontFamily::Sans),

            Tables\Columns\TextColumn::make('item_name')
                ->label('Item Name')
                ->size('xs')
                ->searchable(isIndividual:true,isGlobal:false)
                ->weight(FontWeight::Light)             
                ->fontFamily(FontFamily::Sans)
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
                Tables\Actions\ViewAction::make(),
           Tables\Actions\Action::make('quantity')
   ->label('Qr')
   ->url(fn ($record) => static::getUrl('qr', ['record' => $record]))
    ->openUrlInNewTab(),
   

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
            'index' => Pages\ListReciveItems::route('/'),
           //'create' => Pages\CreateReciveItems::route('/create'),
           // 'edit' => Pages\EditReciveItems::route('/{record}/edit'),
           'qr' => Pages\QR::route('/{record}/quantity'),
        ];
    }
}
