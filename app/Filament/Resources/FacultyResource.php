<?php

namespace App\Filament\Resources;

use App\Models\Faculty;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\FacultyResource\Pages;
use App\Filament\Resources\FacultyResource\RelationManagers\UsersRelationManager;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;

class FacultyResource extends Resource
{
    protected static ?string $model = Faculty::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive';

    protected static ?string $navigationGroup = 'Subject';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 12])->schema([
                    TextInput::make('name')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Enter faculty name')
                        ->lazy()
                        ->afterStateUpdated(function (string $context, $state, callable $set) {
                            if ($context === 'create') {
                                $words = explode(' ', $state);
                                $code = '';

                                foreach ($words as $word) {
                                    if (strtolower($word) === 'dan') {
                                        continue; // Skip the word "dan"
                                    }

                                    $code .= strtoupper(substr($word, 0, 1));
                                }

                                $set('code', $code);
                            }
                        })
                        ->columnSpan([
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    TextInput::make('code')
                        ->disabled()
                        ->unique(Faculty::class, 'code', ignoreRecord: true)
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
                Tables\Columns\TextColumn::make('name')
                    ->toggleable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('code')
                    ->toggleable()
                    ->limit(50),

                TextColumn::make('venues')
                    ->getStateUsing(function ($record) {
                        $faculty = Faculty::find($record->id);
                        $venueCount = $faculty->venues()->count();
                        return $venueCount;
                    }),

                TextColumn::make('subjects')
                    ->getStateUsing(function ($record) {
                        $faculty = Faculty::find($record->id);
                        $subjectCount = $faculty->subjects()->count();
                        return $subjectCount;
                    }),
            ])
            ->filters([DateRangeFilter::make('created_at')]);
    }

    public static function getRelations(): array
    {
        return [
            FacultyResource\RelationManagers\SubjectsRelationManager::class,
            FacultyResource\RelationManagers\LecturersRelationManager::class,
            FacultyResource\RelationManagers\VenuesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFaculties::route('/'),
            'create' => Pages\CreateFaculty::route('/create'),
            'view' => Pages\ViewFaculty::route('/{record}'),
            'edit' => Pages\EditFaculty::route('/{record}/edit'),
        ];
    }
    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
