<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\RelationManagers;
use App\Filament\Widgets\PatientTypeOverview;
use App\Models\Patient;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

use function Laravel\Prompts\select;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;
    protected static ?string $modelLabel = 'Pet';
    protected static ?string $recordTitleAttribute = 'patients';
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(60),
                Forms\Components\DatePicker::make('date_of_birth')
                    ->required()
                    ->maxDate(now()),
                Forms\Components\Select::make('type')
                    ->options([
                        'cat' => 'Cat',
                        'dog' => 'Dog',
                        'rabbit' => 'Rabbit',
                    ])->required(),
                Fieldset::make('Data Owner')->schema([
                    Forms\Components\Select::make('user_id')
                        ->label('Owner')
                        ->relationship('user', 'name')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->when(
                            static::getRolesUser(auth()->user()),
                            function (Forms\Components\Select $select) {
                                return $select->disabledOn('edit');
                            }
                        )
                ])->columns('full')
                    ->when(
                        static::getRolesUser(auth()->user()),
                        fn (Fieldset $fieldset) => $fieldset->hiddenOn('create')
                    ),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Owner')
                    ->searchable(),
            ])
            ->modifyQueryUsing(function (Builder $query): Builder {
                if (static::getRolesUser(auth()->user())) {
                    return $query->where('user_id', auth()->user()->getAuthIdentifier());
                }
                return $query;
            })
            ->filters([
                // Tables\Filters\SelectFilter::make('type')
                //     ->options([
                //         'cat' => 'Cat',
                //         'dog' => 'Dog',
                //         'rabbit' => 'Rabbit',
                //     ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TreatmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'view' => Pages\ViewPatient::route('/{record}'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Pet Patients');
    }

    public static function getWidgets(): array
    {
        return [
            PatientTypeOverview::class,
        ];
    }

    public static function getRolesUser(User $user): bool
    {
        return $user->hasRole('user');
    }

    public static function getRoleAdmin(User $user): bool
    {
        return $user->hasRole(['admin', 'Super-Admin']);
    }

    // public static function queryWherePet(Builder $query): Builder
    // {
    //     if (static::getRolesUser(auth()->user())) {
    //         return $query->where('user_id', auth()->user()->getAuthIdentifier());
    //     }
    //     return $query;
    // }
}
