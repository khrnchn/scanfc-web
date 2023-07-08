<?php

namespace App\Filament\Resources\FacultyResource\RelationManagers;

use App\Enums\VenueType;
use App\Models\Venue;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Enum;

class VenuesRelationManager extends RelationManager
{
    protected static string $relationship = 'venues';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')
                    ->options(VenueType::asSelectArray())
                    ->reactive()
                    ->afterStateUpdated(function (string $context, $state, callable $set) {
                        if ($context === 'create') {
                            if ($state == 0) {
                                $set('name', 'Dewan Kuliah ');
                                $set('code', 'DK');
                            } else if ($state == 1) {
                                $set('name', 'Dewan Seminar ');
                                $set('code', 'DS');
                            } else if ($state == 2) {
                                $set('name', 'Bilik Kuliah ');
                                $set('code', 'BK');
                            }
                        }
                    })
                    ->columnSpan(1),

                Forms\Components\TextInput::make('name')
                    ->unique(Venue::class, 'name', ignoreRecord: true)
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),

                Forms\Components\TextInput::make('code')
                    ->unique(Venue::class, 'code', ignoreRecord: true)
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('code'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
