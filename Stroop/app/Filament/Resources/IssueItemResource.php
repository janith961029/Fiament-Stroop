<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IssueItemResource\Pages;
use App\Filament\Resources\IssueItemResource\RelationManagers;
use Filament\Forms\Get;
use App\Models\ReciveItems;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\FontFamily;
use Filament\Forms\Components\Toggle;
use Filament\Forms;

use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\ictcategories;
use App\Models\titlenames;
use App\Models\stores;
use App\Models\countries;
use App\Models\measures;
use App\Models\rec_places;
use App\Models\PurchaseOrderNos;
use App\Models\Items;
use App\Models\equipment_types;
use App\Models\IssueItem;
use App\Models\IssuingType;
use App\Models\IssuePlaces;
use App\Models\RecPlaces;
use Filament\Forms\Components\CheckboxList;
use App\Models\SignalUnit;


class IssueItemResource extends Resource
{
    protected static ?string $model =ReciveItems::class;
    protected static ?string $modelLabel='Issue Items';
  //  protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup= 'Items';
    protected static ?int $navigationSort = 4;
    public static function getNavigationBadge(): ?string
{
    return static::getModel()::whereNotNull('total_quantity')->where('total_quantity', '!=', '')->count();
}
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Grid::make(3)
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

                    Forms\Components\Select::make('manufactured_country')
                        ->label('manufactured_country')
                        ->disabled()
                        ->options(countries::pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                    TextInput::make('ledger_card_no')
                       ->label('Ledger Card')
                       ->disabled(),

                TextInput::make('total_quantity')
                        ->label('Quantity')                 
                        ->numeric()
                        ->integer()
                        ->disabled()
                        ->minValue(0)
                        ->step(1)
                        ->rules(['required', 'integer', 'min:0'])
                        ->placeholder('Quantity'),
                Select::make('purchase_order_no')
                        ->label('Purchase Order No')
                        ->options(PurchaseOrderNos::pluck('purchase_order_no', 'id'))
                        ->searchable()
                        ->disabled()
                        ->required(),

                TextInput::make('itemprice')
                        ->label('Item Price (LKR)')
                        ->numeric()
                        ->integer()
                        ->disabled()
                        ->minValue(0)
                        ->step(1)
                        ->rules(['required', 'integer', 'min:0'])
                        ->placeholder('PRICE'),
                                        
                Select::make('received_place')
                        ->label('Received From')
                        ->disabled()
                        ->options(RecPlaces::pluck('Rec_place', 'id'))
                        ->searchable()->required(),
        
                DatePicker::make('received_date')
                        ->label('Received Date ')
                        ->disabled()
                        ->required(),
                DatePicker::make('warrenty_expiry_date')
                        ->label('Warranty Expiry Date')
                        ->disabled()
                        ->required(),
                TextInput::make('commander_reserve')
                       ->disabled()
                       ->label('Commander Reserve'),
       
                TextInput::make('remarks_recieved')
                       ->disabled()
                       ->label('Remarks/Recieved'),

                ])
                ->columns(3),
                
        
            Section::make('Serial Numbers')
                ->schema([
                    Repeater::make('serial')
                    ->disableItemDeletion()
                        ->relationship(
                            'serial_numbers',
                            fn (Builder $query) => $query->where('recieved', 1)
                                ->where(function ($query) {
                                    $query->where('issued', 0)
                                          ->orWhereNull('issued');
                                })
                        )
                        ->schema([
                            TextInput::make('serial_number')->disabled(),
                             TextInput::make('barcode')->required()->disabled(),
                            Toggle::make('issued')->label('Issued'),
                        ])
               ])]),
                Section::make('Common Issue Details')
    ->schema([
        DatePicker::make('assigned_date')
        ->label('Assigned Date')
        
        ->dehydrated(false),
        Select::make('issue_place')
        ->label('Issue Place')
        ->options(IssuePlaces::pluck('issue_place', 'id'))
        ->searchable()->dehydrated(false),
        Select::make('issuing_type')
        ->label('Issuing Type')
        ->options(IssuingType::pluck('issuing_type', 'id'))
        ->searchable()->dehydrated(false),
        TextInput::make('job_card_number')
        ->label('Job Card Number')
        ->dehydrated(false),
        Select::make('signal_unit')
        ->label('Signal Unit')
        ->options(SignalUnit::pluck('sig_unit_name', 'id'))->searchable()->dehydrated(false),
    ])->columns(2),
])     ;
        
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

            Tables\Columns\TextColumn::make('items.item_code')
            ->label('Item Code')
            ->sortable()
            ->searchable(isIndividual:true,isGlobal:false)
            ->size('xs')
            ->weight(FontWeight::Light)             
            ->fontFamily(FontFamily::Sans),
            Tables\Columns\TextColumn::make('ledger_card_no')
                ->label('ledger Card No')
                ->size('xs')
                ->weight(FontWeight::Light)             
                ->fontFamily(FontFamily::Sans),
                 Tables\Columns\TextColumn::make('warrenty_expiry_date')
                ->label('Warrenty Expire Date')
                ->size('xs')
                ->weight(FontWeight::Light)             
                ->fontFamily(FontFamily::Sans),
           
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('quantity')

                ->url(fn ($record) => static::getUrl('quantity', ['record' => $record]))
                ->openUrlInNewTab(),
   
             
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
            'index' => Pages\ListIssueItems::route('/'),
           // 'create' => Pages\CreateIssueItem::route('/create'),
           'edit' => Pages\EditIssueItem::route('/{record}/edit'),
           'quantity' => Pages\Quantity::route('/{record}/quantity'),
        ];
    }
}
