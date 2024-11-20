<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\ListUserActivities;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Activitylog\Models\Activity;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 5;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User Details')
                    ->schema([
                        Grid::make()
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                            ]),
                    ]),

                Section::make('Change Password')
                    ->columns()
                    ->schema([
                        TextInput::make('password')
                            ->label(__('filament-panels::pages/auth/register.form.password.label'))
                            ->required(static fn(Page $livewire): string => $livewire instanceof Pages\CreateUser)
                            ->password()
                            ->revealable(filament()->arePasswordsRevealable())
                            ->rule(Password::default())
                            ->same('passwordConfirmation')
                            ->validationAttribute(__('filament-panels::pages/auth/register.form.password.validation_attribute'))
                            ->maxLength(50)
                            ->minLength(8)
                            ->dehydrated(static fn(null|string $state): bool => filled($state))
                            ->dehydrateStateUsing(
                                static fn(null|string $state): null|string => filled($state) ? Hash::make($state) : null
                            ),

                        TextInput::make('passwordConfirmation')
                            ->label(__('filament-panels::pages/auth/register.form.password_confirmation.label'))
                            ->required(static fn(Page $livewire): string => $livewire instanceof Pages\CreateUser)
                            ->password()
                            ->revealable(filament()->arePasswordsRevealable())
                            ->maxLength(50)
                            ->minLength(8)
                            ->dehydrated(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->weight(FontWeight::Bold)
                    ->searchable(['name']),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(),

                /*
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
                */

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                /*
                Tables\Filters\SelectFilter::make('status')
                    ->options(UserStatus::class)
                    ->multiple(),
                */
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(false),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return self::getEloquentQuery()->count();
    }

}
