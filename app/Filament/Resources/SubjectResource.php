<?php

namespace App\Filament\Resources;

use App\Models\Subject;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\SubjectResource\Pages;

class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Subject';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    TextInput::make('name')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Name')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('faculty_id')
                        ->rules(['exists:faculties,id'])
                        ->required()
                        ->relationship('faculty', 'name')
                        ->searchable()
                        ->placeholder('Faculty')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('60s')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('faculty.name')
                    ->toggleable()
                    ->limit(50),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('faculty_id')
                    ->relationship('faculty', 'name')
                    ->indicator('Faculty')
                    ->multiple()
                    ->label('Faculty'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            SubjectResource\RelationManagers\SectionsRelationManager::class,
            SubjectResource\RelationManagers\ClassroomsRelationManager::class,
            SubjectResource\RelationManagers\LecturersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubjects::route('/'),
            'create' => Pages\CreateSubject::route('/create'),
            'view' => Pages\ViewSubject::route('/{record}'),
            'edit' => Pages\EditSubject::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
