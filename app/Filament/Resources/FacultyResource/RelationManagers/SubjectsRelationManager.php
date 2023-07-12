<?php

namespace App\Filament\Resources\FacultyResource\RelationManagers;

use App\Filament\Resources\SubjectResource;
use App\Filament\Resources\SubjectResource\Pages\ViewSubject;
use App\Models\Faculty;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\ViewAction;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'subjects';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->rules(['max:255', 'string'])
                    ->required()
                    ->placeholder('Enter subject name')
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                TextInput::make('code')
                    ->required()
                    ->rules(['max:255', 'string'])
                    ->placeholder('Enter subject code')
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                // takyah sebab dalam relation manager

                // Select::make('faculty_id')
                //     ->label('Faculty')
                //     ->rules(['exists:faculties,id'])
                //     ->required()
                //     ->options(Faculty::all()->pluck('name', 'id'))
                //     ->searchable()
                //     ->placeholder('Select faculty')
                //     ->columnSpan([
                //         'default' => 12,
                //         'md' => 12,
                //         'lg' => 12,
                //     ]),

                FileUpload::make('image_path')
                    ->placeholder('Upload subject image')
                    ->image()
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                BadgeColumn::make('code')
                    ->color('success'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Action::make('view')
                    ->color('secondary')
                    ->icon('heroicon-s-eye')
                    ->action(function ($record, $livewire) {
                        $livewire->redirect(SubjectResource::getURL('view', $record->id));
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->contentGrid([
                'default' => 1,
                'md' => 2,
                'xl' => 3,
            ]);
    }
}
