<?php

namespace App\Filament\Resources;

use App\Models\Student;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\StudentResource\Pages;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\BadgeColumn;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?string $recordTitleAttribute = 'matrix_id';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    TextInput::make('matrix_id')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Matrix Id')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),


                    Select::make('user_id')
                        ->rules(['exists:users,id'])
                        ->required()
                        ->relationship('user', 'name')
                        ->searchable()
                        ->placeholder('User')
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

                    Toggle::make('is_active')
                        ->rules(['boolean'])
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,

                            Hidden::make('nfc_tag')
                                ->default(''),
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
                Tables\Columns\TextColumn::make('matrix_id')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('nfc_tag')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('user.name')
                    ->toggleable()
                    ->limit(50),
                BadgeColumn::make('faculty.code')
                    ->label('Faculty')
                    ->getStateUsing(function ($record) {
                        if ($record->faculty_id == 1) {
                            return 'FSKM';
                        } else if ($record->faculty_id == 2) {
                            return 'FPP';
                        } else if ($record->faculty_id == 3) {
                            return 'FSSR';
                        } else if ($record->faculty_id == 4) {
                            return 'FPN';
                        } else if ($record->faculty_id == 5) {
                            return 'FKPM';
                        } else if ($record->faculty_id == 6) {
                            return 'FPHP';
                        }

                        return '';
                    })
                    ->colors([
                        'success',
                    ]),
                Tables\Columns\IconColumn::make('is_active')
                    ->toggleable()
                    ->boolean(),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->indicator('User')
                    ->multiple()
                    ->label('User'),

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
            StudentResource\RelationManagers\SectionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'view' => Pages\ViewStudent::route('/{record}'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }
}
