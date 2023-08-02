<?php

namespace App\Filament\Resources\SectionResource\RelationManagers;

use App\Models\Venue;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;

class ClassroomsRelationManager extends RelationManager
{
    protected static string $relationship = 'classrooms';

    protected static ?string $title = 'Schedules';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Grid::make(['default' => 12])->schema([
                TextInput::make('name')
                    ->rules(['max:255', 'string'])
                    ->placeholder('Enter lecture or lab')
                    ->columnSpan([
                        'default' => 4,
                        'md' => 4,
                        'lg' => 4,
                    ]),

                Select::make('type')
                    ->required()
                    ->options([
                        '0' => 'Physical',
                        '1' => 'Online',
                    ])
                    ->columnSpan([
                        'default' => 4,
                        'md' => 4,
                        'lg' => 4,
                    ]),

                Select::make('venue_id')
                    ->options(Venue::pluck('name', 'id'))
                    ->searchable()
                    ->placeholder('Select venue')
                    ->columnSpan([
                        'default' => 4,
                        'md' => 4,
                        'lg' => 4,
                    ]),

                DateTimePicker::make('start_at')
                    ->rules(['date'])
                    ->placeholder('Select start time')
                    ->withoutSeconds()
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                DateTimePicker::make('end_at')
                    ->rules(['date'])
                    ->placeholder('Select end time')
                    ->withoutSeconds()
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('lecturer.user.name')
                //     ->limit(50)
                //     ->label('Lecturer'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Type')
                    ->limit(50),
                TextColumn::make('day')
                    ->getStateUsing(function ($record) {
                        $startAt = $record->start_at;
                        $carbonDate = Carbon::parse($startAt);
                        $dayOfWeek = $carbonDate->format('l');

                        return $dayOfWeek;
                    }),
                Tables\Columns\TextColumn::make('start_at'),
                Tables\Columns\TextColumn::make('end_at'),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '>=',
                                    $date
                                )
                            )
                            ->when(
                                $data['created_until'],
                                fn (
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '<=',
                                    $date
                                )
                            );
                    }),

                MultiSelectFilter::make('subject_id')->relationship(
                    'subject',
                    'name'
                ),

                MultiSelectFilter::make('section_id')->relationship(
                    'section',
                    'name'
                ),
            ])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }
}
