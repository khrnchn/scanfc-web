<?php

namespace App\Filament\Resources;

use App\Models\Classroom;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\ClassroomResource\Pages;

class ClassroomResource extends Resource
{
    protected static ?string $model = Classroom::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Subject';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    Select::make('subject_id')
                        ->rules(['exists:subjects,id'])
                        ->required()
                        ->relationship('subject', 'name')
                        ->searchable()
                        ->placeholder('Subject')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('section_id')
                        ->rules(['exists:sections,id'])
                        ->required()
                        ->relationship('section', 'name')
                        ->searchable()
                        ->placeholder('Section')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('lecturer_id')
                        ->rules(['exists:lecturers,id'])
                        ->required()
                        ->relationship('lecturer', 'staff_id')
                        ->searchable()
                        ->placeholder('Lecturer')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('name')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Name')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    DatePicker::make('start_at')
                        ->rules(['date'])
                        ->required()
                        ->placeholder('Start At')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    DatePicker::make('end_at')
                        ->rules(['date'])
                        ->required()
                        ->placeholder('End At')
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
                Tables\Columns\TextColumn::make('subject.name')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('section.name')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('lecturer.staff_id')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('name')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('start_at')
                    ->toggleable()
                    ->date(),
                Tables\Columns\TextColumn::make('end_at')
                    ->toggleable()
                    ->date(),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('subject_id')
                    ->relationship('subject', 'name')
                    ->indicator('Subject')
                    ->multiple()
                    ->label('Subject'),

                SelectFilter::make('section_id')
                    ->relationship('section', 'name')
                    ->indicator('Section')
                    ->multiple()
                    ->label('Section'),

                SelectFilter::make('lecturer_id')
                    ->relationship('lecturer', 'staff_id')
                    ->indicator('Lecturer')
                    ->multiple()
                    ->label('Lecturer'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ClassroomResource\RelationManagers\AttendancesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassrooms::route('/'),
            'create' => Pages\CreateClassroom::route('/create'),
            'view' => Pages\ViewClassroom::route('/{record}'),
            'edit' => Pages\EditClassroom::route('/{record}/edit'),
        ];
    }
    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
