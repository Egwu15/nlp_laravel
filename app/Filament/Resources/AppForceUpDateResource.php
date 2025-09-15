<?php

namespace App\Filament\Resources;

use App\Enums\AppPlatForms;
use App\Filament\Resources\AppForceUpDateResource\Pages;
use App\Filament\Resources\AppForceUpDateResource\RelationManagers;
use App\Models\AppForceUpDate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppForceUpDateResource extends Resource
{
    protected static ?string $model = AppForceUpDate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('platform')
                    ->options([
                        AppPlatForms::Android->value => 'Android',
                        AppPlatForms::IOS->value => 'IOS',
                    ])
                    ->required()
                    ->default(0),
                Forms\Components\TextInput::make('app_min_version')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('app_latest_version')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('update_message')
                    ->default("A new version of the app is available. Would you like to update now for the best experience?")
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('platform')
                    ->formatStateUsing(fn($state) => $state->name)
                    ->sortable(),
                Tables\Columns\TextColumn::make('app_min_version')
                    ->searchable(),
                Tables\Columns\TextColumn::make('app_latest_version')
                    ->searchable(),
                Tables\Columns\TextColumn::make('update_message')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListAppForceUpDates::route('/'),
            'create' => Pages\CreateAppForceUpDate::route('/create'),
            'edit' => Pages\EditAppForceUpDate::route('/{record}/edit'),
        ];
    }
}
