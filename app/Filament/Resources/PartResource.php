<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartResource\Pages;
use App\Models\Part;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use App\Models\Law;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;

class PartResource extends Resource
{
    protected static ?string $model = Part::class;

    protected static ?string $navigationGroup = 'Laws';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required(),

                Select::make('law_id')
                    ->label('Law')
                    ->options(Law::all()->pluck('title', 'id'))
                    ->reactive()
                    ->afterStateUpdated(fn(Set $set) => $set('chapter_id', null))
                    ->required(),

                TextInput::make('number')
                    ->numeric()
                    ->required(),

                Select::make('chapter_id')
                    ->label('Chapter')
                    ->options(function (Get $get) {
                        $lawId = $get('law_id');
                        if (!$lawId) {
                            return [];
                        }
                        return Law::find($lawId)->chapters()->pluck('title', 'id');
                    })
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('chapter.title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('chapter.law.title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('number')
                    ->numeric()
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListParts::route('/'),
            'create' => Pages\CreatePart::route('/create'),
            'edit' => Pages\EditPart::route('/{record}/edit'),
        ];
    }
}
