<?php

namespace App\Filament\Resources\SubjectResource\RelationManagers;

use App\Filament\Resources\SectionResource;
use App\Models\Lecturer;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;

class SectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sections';

    protected static ?string $title = 'Groups';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([
                TextInput::make('name')
                    ->rules(['max:255', 'string'])
                    ->placeholder('Eg: A, B, C...')
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ]),
                Select::make('lecturer_id')
                    ->options(function ($livewire) {
                        $facultyId = $livewire->ownerRecord->faculty_id;

                        return Lecturer::whereHas('user', function ($query) use ($facultyId) {
                            $query->where('faculty_id', $facultyId);
                        })->with('user')->get()->mapWithKeys(function ($lecturer) {
                            return [$lecturer->id => $lecturer->user->name . ' - ' . $lecturer->staff_id];
                        });
                    })
                    ->searchable()
                    ->placeholder('Select lecturer')
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Group')
                    ->limit(50),
                TextColumn::make('qty')
                    ->label('Students')
                    ->getStateUsing(function ($record) {
                        return $record->students->count();
                    }),
                TextColumn::make('lecturer.user.name')
                    ->label('Taught by'),
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
            ])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([
                Action::make('view')
                    ->color('secondary')
                    ->icon('heroicon-s-eye')
                    ->action(function ($record, $livewire) {
                        $livewire->redirect(SectionResource::getURL('view', $record->id));
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }
}
