<?php

namespace App\Filament\Resources\SectionResource\RelationManagers;

use App\Enums\AttendanceStatusEnum;
use App\Enums\ClassTypeEnum;
use App\Enums\ExemptionStatusEnum;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Enrollment;
use App\Models\Section;
use App\Models\Student;
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
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
                BadgeColumn::make('name')
                    ->label('Type')
                    ->limit(30)
                    ->color(static function ($state): string {
                        if ($state === 'Lecture') {
                            return 'success';
                        }

                        return 'primary';
                    }),
                TextColumn::make('day')
                    ->getStateUsing(function ($record) {
                        $startAt = $record->start_at;
                        $carbonDate = Carbon::parse($startAt);
                        $dayOfWeek = $carbonDate->format('l');

                        return $dayOfWeek . ', ' . Carbon::parse($record->start_at)->format('d F Y');
                    }),
                Tables\Columns\TextColumn::make('start_at')
                    ->formatStateUsing(function ($record) {
                        return Carbon::parse($record->start_at)->format('h:i a');
                    }),
                Tables\Columns\TextColumn::make('end_at')
                    ->formatStateUsing(function ($record) {
                        return Carbon::parse($record->end_at)->format('h:i a');
                    }),
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
                Action::make('qr')
                    ->label('QR Code')
                    ->icon('heroicon-o-qrcode')
                    ->color('danger')
                    ->hidden(function ($record) {
                        if ($record->type != ClassTypeEnum::Physical()->value) {
                            if ($record->hasRecordedAttendance == false) {
                                return false;
                            }
                            return true;
                        }

                        return true;
                    })
                    ->modalHeading(function ($record) {
                        return 'QR Code for section ' . $record->section->name . ', class ' . $record->name;
                    })
                    ->modalButton('Stop recording')
                    ->modalWidth('sm')
                    ->modalContent(fn ($record): View => view(
                        'filament.pages.displayQr',
                        ['record' => $record],
                    ))
                    ->action(function ($record) {
                        $record->update(['hasRecordedAttendance' => true]);

                        $enrolledIds = Enrollment::where('section_id', $record->section_id)->pluck('id');
                        $attendedIds = Attendance::where('classroom_id', $record->id)->pluck('enrollment_id');

                        $notAttendedIds = $enrolledIds->diff($attendedIds);

                        foreach ($notAttendedIds as $enrollmentId) {
                            $attendance = Attendance::create([
                                'classroom_id' => $record->id,
                                'enrollment_id' => $enrollmentId,
                                'attendance_status' => AttendanceStatusEnum::Absent(),
                                'exemption_status' => ExemptionStatusEnum::ExemptionNeeded(),
                            ]);
                        }

                        // notification
                        $scannedStudentsName = [];
                        $enrollmentIds = Attendance::where('classroom_id', $record->id)->pluck('enrollment_id');

                        foreach ($enrollmentIds as $enrollmentId) {
                            $enrollment = Enrollment::where('id', $enrollmentId)->first();
                            $name = $enrollment->student->user->name;
                            $scannedStudentsName[] = $name;
                        }

                        $scannedStudentsNamesString = implode(', ', $scannedStudentsName);

                        Notification::make('attendanceCreated')
                            ->title('Attendance record success!')
                            ->body('Successfully recorded attendance for: ' . $scannedStudentsNamesString)
                            ->seconds(5)
                            ->success()
                            ->send();
                    }),

                Action::make('history')
                    ->icon('heroicon-o-clipboard-list')
                    ->hidden(fn ($record) => $record->hasRecordedAttendance == false),

                Action::make('attendance')
                    ->icon('heroicon-o-plus-circle')
                    ->color('success')
                    ->modalButton('Submit attendance')
                    ->modalWidth('sm')
                    ->hidden(function ($record) {
                        $today = Carbon::today();

                        // Show the action button if it's the current day
                        if (!$record->start_at || !$record->start_at->isSameDay($today)) {
                            return true;
                        }

                        // Hide the action button if attendance is already recorded or it's an online class
                        return $record->hasRecordedAttendance || $record->type === ClassTypeEnum::Online()->value;
                    })
                    ->form([
                        Textarea::make('uuids')
                            ->label('Student UUIDs')
                            ->required(),
                    ])
                    ->action(function ($data, $livewire, $record) {
                        // 1. get uuid for all student that enroll in that section, $enrolledUuids
                        $studentIds = Enrollment::where('section_id', $record->section_id)->pluck('student_id');

                        $enrolledUuids = [];
                        foreach ($studentIds as $studentId) {
                            $uuid = Student::where('id', $studentId)->value('nfc_tag');
                            if ($uuid) {
                                $enrolledUuids[] = $uuid;
                            }
                        }

                        // 2. For UUIDs that were just pasted, create Attendance models with status 'Present'
                        $scannedUuids = explode("\n", trim($data['uuids']));
                        $scannedUuids = array_filter($scannedUuids);
                        $scannedUuids = array_unique($scannedUuids);

                        foreach ($scannedUuids as $scannedUuid) {
                            if (in_array($scannedUuid, $enrolledUuids)) {
                                $studentId = Student::where('nfc_tag', $scannedUuid)->value('id'); //3
                                $enrollmentId = Enrollment::where([
                                    'section_id' => $record->section_id,
                                    'student_id' => $studentId,
                                ])->value('id'); //7

                                Attendance::create([
                                    'classroom_id' => $record->id,
                                    'enrollment_id' => $enrollmentId,
                                    'attendance_status' => AttendanceStatusEnum::Present(),
                                    'exemption_status' => null,
                                    'exemption_file' => null,
                                ]);
                            }
                        }

                        // 3. for uuids that other than that, create attendance model with status Absent
                        $absentUuids = array_diff($enrolledUuids, $scannedUuids);

                        foreach ($absentUuids as $absentUuid) {
                            $studentId = Student::where('nfc_tag', $absentUuid)->value('id');
                            $enrollmentId = Enrollment::where([
                                'section_id' => $record->section_id,
                                'student_id' => $studentId,
                            ])->value('id');

                            Attendance::create([
                                'classroom_id' => $record->id,
                                'enrollment_id' => $enrollmentId,
                                'attendance_status' => AttendanceStatusEnum::Absent(),
                                'exemption_status' => ExemptionStatusEnum::ExemptionNeeded(),
                                'exemption_file' => null,
                            ]);
                        }

                        $record->update(['hasRecordedAttendance' => true]);

                        $students = Student::whereIn('nfc_tag', $scannedUuids)->with('user')->get();
                        $studentNames = $students->pluck('user.name')->implode(', ');

                        Notification::make('attendanceCreated')
                            ->title('Attendance record success!')
                            ->body('Successfully recorded attendance for: ' . $studentNames)
                            ->seconds(5)
                            ->success()
                            ->send();
                    })
            ])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }
}
