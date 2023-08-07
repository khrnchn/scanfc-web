<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\Faculty;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Exists;

class StudentRelationManager extends RelationManager
{
    protected static string $relationship = 'student';

    protected static ?string $recordTitleAttribute = 'matrix_id';

    protected static ?string $title = 'Student Data';

    public static function canViewForRecord(Model $ownerRecord): bool
    {
        return strpos($ownerRecord->email, '@student.uitm.com') !== false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('matrix_id')
                    ->required()
                    ->maxLength(10),

                TextInput::make('faculty_id')
                    ->label('Faculty')
                    ->disabled()
                    ->default(function ($livewire) {
                        $facultyName = Faculty::where('id', $livewire->ownerRecord->faculty_id)->value('name');
                        return $facultyName;
                    }),

                Toggle::make('is_active')
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('matrix_id'),
                BadgeColumn::make('nfc_tag')
                    ->getStateUsing(function ($record) {
                        if ($record->nfc_tag == '') {
                            return 'No NFC registered';
                        }
                    })
                    ->color(static function ($state): string {
                        if ($state === 'No NFC registered' || '') {
                            return 'danger';
                        }

                        return 'success';
                    })
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Assign student data')
                    ->mutateFormDataUsing(function (array $data): array {
                        $facultyId = Faculty::where('name', $data['faculty_id'])->value('id');
                        $data['faculty_id'] = $facultyId;

                        return $data;
                    })
                    ->hidden(function (RelationManager $livewire) {
                        return $livewire->ownerRecord->student !== null;
                    }),
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
