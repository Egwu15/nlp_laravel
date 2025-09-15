<?php

namespace App\Filament\Resources;

use App\Enums\Role;
use App\Filament\Resources\AccessPlanResource\Pages;
use App\Filament\Resources\AccessPlanResource\RelationManagers;
use App\Filament\Resources\AccessPlanResource\RelationManagers\CourtRuleRelationManager;
use App\Filament\Resources\AccessPlanResource\RelationManagers\LawRelationManager;
use App\Models\AccessPlan;
use App\Models\Law;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class AccessPlanResource extends Resource
{
    protected static ?string $model = AccessPlan::class;

    protected static ?string $navigationGroup = 'Plans';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('duration_days')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('google_product_id')
                    ->required(),
                Forms\Components\TextInput::make('discount_price')
                    ->default(0)
                    ->numeric(),
                Forms\Components\DateTimePicker::make('discount_expires_at')->minDate(now()),
                Forms\Components\Toggle::make('active')
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('google_product_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_days')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_expires_at')
                    ->dateTime()
                    ->sortable(),
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
            LawRelationManager::class,
            CourtRuleRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccessPlans::route('/'),
            'create' => Pages\CreateAccessPlan::route('/create'),
            'edit' => Pages\EditAccessPlan::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        /**@var User $user */
        $user = Auth::user();
        return $user->role === Role::Admin;
    }
}
