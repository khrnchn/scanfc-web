<?php

namespace App\Filament\Resources\SectionResource\RelationManagers;

use App\Models\Enrollment;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';

    protected static ?string $recordTitleAttribute = 'matrix_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user.name')
                    ->label('Student')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('matrix_id'),
                Tables\Columns\TextColumn::make('nfc_tag'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Assign')
                    ->recordSelectSearchColumns(['user.name'])
                    ->recordTitle(fn (Student $record): string => $record->user->name)
                    ->recordSelectOptionsQuery(function (Builder $query, $livewire) {
                        // Get subjectId
                        $subjectId = $livewire->ownerRecord->subject->id;

                        // Get all groups belong to this subject
                        $sectionIds = Section::where('subject_id', $subjectId)->pluck('id');

                        // init empty array 
                        $enrolledStudentIds = [];
                        foreach ($sectionIds as $sectionId) {
                            // get studentId that has enrolled
                            $studentIds = Enrollment::where('section_id', $sectionId)->pluck('student_id');
                            foreach ($studentIds as $studentId) {
                                // insert studentId into empty array
                                $enrolledStudentIds[] = $studentId;
                            }
                        }

                        // get all studentId
                        $allStudentIds = Student::pluck('id');

                        // compare allStudentIds with enrolledStudentIds
                        $notEnrolledIds = array_diff($allStudentIds->toArray(), $enrolledStudentIds);

                        // query returns those who have not enrolled yet
                        $query->whereIn('id', $notEnrolledIds);
                    })
                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()
                    ->label('Drop'),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }
}
