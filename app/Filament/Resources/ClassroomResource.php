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

    protected static ?string $navigationLabel = 'Schedule';

    protected static ?string $slug = 'schedules';

    protected static ?string $modelLabel = 'Schedule';

    protected static ?string $recordTitleAttribute = 'name';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 12])->schema([
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

                    TextInput::make('name')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Name')
                        ->columnSpan([
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    Select::make('type')
                        ->required()
                        ->options([
                            '0' => 'Physical',
                            '1' => 'Online',
                        ])
                        ->columnSpan([
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    DatePicker::make('start_at')
                        ->rules(['date'])
                        ->required()
                        ->placeholder('Start At')
                        ->columnSpan([
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    DatePicker::make('end_at')
                        ->rules(['date'])
                        ->required()
                        ->placeholder('End At')
                        ->columnSpan([
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
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
