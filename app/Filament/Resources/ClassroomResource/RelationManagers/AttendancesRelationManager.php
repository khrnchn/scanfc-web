<?php

namespace App\Filament\Resources\ClassroomResource\RelationManagers;

use App\Enums\AttendanceStatusEnum;
use App\Enums\ExemptionStatusEnum;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\{Form, Table};
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\View\View;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Enums\ClassTypeEnum;

class AttendancesRelationManager extends RelationManager
{
    protected static string $relationship = 'attendances';

    protected static ?string $recordTitleAttribute = 'status';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('enrollment.student.user.name')
                    ->limit(50),
                BadgeColumn::make('attendance_status')
                    ->label('Status')
                    ->formatStateUsing(function ($record) {
                        if ($record->attendance_status == AttendanceStatusEnum::Present()) {
                            return AttendanceStatusEnum::Present()->label;
                        } else {
                            if ($record->exemption_status == ExemptionStatusEnum::ExemptionNeeded()) {
                                return AttendanceStatusEnum::Absent()->label . ' without exemption';
                            }
                            return AttendanceStatusEnum::Absent()->label . ' with exemption';
                        }
                    })
                    ->color(static function ($state): string {
                        if ($state == AttendanceStatusEnum::Present()) {
                            return 'success';
                        }

                        return 'danger';
                    }),
                TextColumn::make('created_at')
                    ->label('Recorded at')
                    ->formatStateUsing(fn ($record) => Carbon::parse($record->created_at)->format('d F Y h:i a'))

            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                FilamentExportHeaderAction::make('report')
                    ->defaultFormat('pdf')
                    ->withColumns([
                        TextColumn::make('enrollment.section.name')->label('Group'),
                        TextColumn::make('classroom.name')->label('Class name'),
                        TextColumn::make('classroom.type')->label('Class type')->getStateUsing(function ($record) {
                            if ($record == ClassTypeEnum::Online()) {
                                return ClassTypeEnum::Online()->label;
                            }

                            return ClassTypeEnum::Physical()->label;
                        }),
                        TextColumn::make('enrollment.section.subject.name')->label('Subject'),
                    ]),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
                Action::make('exemption')
                    ->icon('heroicon-o-document-text')
                    ->color('danger')
                    ->hidden(fn ($record) => $record->attendance_status == AttendanceStatusEnum::Present())
                    ->action(function ($record) {
                    })
                    ->modalWidth('sm')
                    ->modalContent(fn ($record): View => view(
                        'filament.pages.displayExemption',
                        ['record' => $record],
                    ))
            ])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }
}
