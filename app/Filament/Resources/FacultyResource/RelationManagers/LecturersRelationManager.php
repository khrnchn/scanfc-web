<?php

namespace App\Filament\Resources\FacultyResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LecturersRelationManager extends RelationManager
{
    protected static string $relationship = 'lecturers';

    protected static ?string $recordTitleAttribute = 'staff_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('staff_id')
                    ->required()
                    ->placeholder('Enter staff ID')
                    ->maxLength(255),
                TextInput::make('name')
                    ->required()
                    ->placeholder('Enter staff name')
                    ->maxLength(255),
                TextInput::make('email')
                    ->required()
                    ->placeholder('Enter staff email')
                    ->maxLength(255),
                TextInput::make('phone_no')
                    ->required()
                    ->placeholder('Enter staff phone number')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('staff_id'),
                TextColumn::make('user.name'),
                TextColumn::make('user.email'),
                TextColumn::make('user.phone_no'),
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
