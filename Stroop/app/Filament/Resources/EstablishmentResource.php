<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EstablishmentResource\Pages;
use App\Filament\Resources\EstablishmentResource\RelationManagers;
use App\Models\Establishment;
use Filament\Forms;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\FontFamily;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EstablishmentResource extends Resource
{
    protected static ?string $model = Establishment::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
  
     
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('establishment')
                    ->label('Establishment')
                    ->required(),
                TextInput::make('establishment_details')
                    ->label('Details')
                    ->required(),
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

            Tables\Columns\TextColumn::make('establishment')
            ->label('Establishment Name')
            ->sortable()
            ->searchable(isIndividual:true,isGlobal:false)
            ->size('xs')
            ->weight(FontWeight::Light)             
            ->fontFamily(FontFamily::Sans),
            Tables\Columns\TextColumn::make('establishment_details')
                ->label('Details')
                ->size('xs')
                ->weight(FontWeight::Light)             
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
            'index' => Pages\ListEstablishments::route('/'),
            'create' => Pages\CreateEstablishment::route('/create'),
            'edit' => Pages\EditEstablishment::route('/{record}/edit'),
        ];
    }
}
