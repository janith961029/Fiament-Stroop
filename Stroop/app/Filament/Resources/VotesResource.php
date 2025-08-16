<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VotesResource\Pages;
use App\Filament\Resources\VotesResource\RelationManagers;
use App\Models\Votes;
use Filament\Forms;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\FontFamily;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VotesResource extends Resource
{
    protected static ?string $model = Votes::class;

    protected static ?string $navigationIcon = 'heroicon-o-hand-thumb-up';
public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('vote_head')
                    ->label('Vote Head')
                    ->required(),
                TextInput::make('description')
                    ->label('Description')
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

            Tables\Columns\TextColumn::make('vote_head')
            ->label('Vote Head')
            ->sortable()
            ->searchable(isIndividual:true,isGlobal:false)
            ->size('xs')
            ->weight(FontWeight::Light)             
            ->fontFamily(FontFamily::Sans),
            Tables\Columns\TextColumn::make('description')
                ->label('Description')
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
            'index' => Pages\ListVotes::route('/'),
            'create' => Pages\CreateVotes::route('/create'),
            'edit' => Pages\EditVotes::route('/{record}/edit'),
        ];
    }
}
