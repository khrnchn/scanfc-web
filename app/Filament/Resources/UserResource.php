<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Livewire\Component;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\UserResource\Pages;
use App\Models\Faculty;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\BadgeColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'User Management';

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

                    TextInput::make('email')
                        ->rules(['email'])
                        ->required()
                        ->unique(
                            'users',
                            'email',
                            fn (?Model $record) => $record
                        )
                        ->email()
                        ->placeholder('Email')
                        ->columnSpan([
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    TextInput::make('password')
                        ->required()
                        ->password()
                        ->dehydrateStateUsing(fn ($state) => \Hash::make($state))
                        ->required(
                            fn (Component $livewire) => $livewire instanceof
                                Pages\CreateUser
                        )
                        ->placeholder('Password')
                        ->columnSpan([
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    TextInput::make('phone_no')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Phone No')
                        ->mask(fn (TextInput\Mask $mask) => $mask->pattern('+{601}0-00000000'))
                        ->columnSpan([
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    Select::make('faculty_id')
                        ->label('Faculty')
                        ->options(Faculty::all()->pluck('name', 'id'))
                        ->columnSpan([
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
                        ])
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
                Tables\Columns\TextColumn::make('email')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('phone_no')
                    ->toggleable()
                    ->limit(50),
                BadgeColumn::make('faculty_id')
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
            ])
            ->filters([DateRangeFilter::make('created_at')]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
