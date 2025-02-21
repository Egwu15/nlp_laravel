<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SectionResource\Pages;
use App\Filament\Resources\SectionResource\RelationManagers;
use App\Models\Section;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\MarkdownEditor;
use Closure;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Builder;



class SectionResource extends Resource
{
    protected static ?string $model = Section::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            // Law selection – uses session default if available.
            Select::make('law_id')
                ->label('Law')
                ->options(\App\Models\Law::pluck('title', 'id'))
                ->afterStateHydrated(function ($state, callable $set) {
                    if (empty($state)) {
                        // Force-set the law_id from the session, if available.
                        $set('law_id', session('last_used_law_id'));
                    }
                })
                ->afterStateUpdated(function ($state, callable $set) {
                    // When the law changes, set part_id to null.
                    $set('part_id', null);
                })
                ->live()
                ->required(),

            // Part selection – uses session default if available.
            Select::make('part_id')
                ->label('Part')
                ->options(\App\Models\Part::pluck('title', 'id'))
                ->afterStateHydrated(function ($state, callable $set) {
                    if (empty($state)) {
                        $set('part_id', session('last_used_part_id'));
                    }
                })
                ->required(),

            // Section number (required, numeric)
            TextInput::make('number')
                ->label('Section Number')
                ->required()
                ->numeric()
                ->rules([
                    // Use the closure syntax as in the documentation.
                    fn(): Closure => function (string $attribute, $value, Closure $fail) {

                        $lawId = request()->input('law_id') ?? session('last_used_law_id');
                        if (!$lawId) {
                            return;
                        }
                        if (Section::where('law_id', $lawId)
                            ->where('number', $value)
                            ->exists()
                        ) {
                            $fail('A section with this law and number already exists.');
                        }
                    },
                ]),

            // Section content (Markdown Editor)
            MarkdownEditor::make('content')
                ->label('Content')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('part.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('law.title')
                    ->sortable()
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
                Tables\Actions\ViewAction::make(),
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
            'create' => Pages\CreateSection::route('/create'),
            'index' => Pages\ListSections::route('/'),
            'view' => Pages\ViewSection::route('/{record}'),
            'edit' => Pages\EditSection::route('/{record}/edit'),
        ];
    }
}
