<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KurumlarResource\Pages;
use App\Filament\Resources\KurumlarResource\RelationManagers;
use App\Models\Kurumlar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KurumlarResource extends Resource
{
    protected static ?string $model = Kurumlar::class;
    protected static ?string $label = 'Kurum & Kişi';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kurumAdi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kurum_slug')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kurumEmail')
                    ->email()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kurumAdi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kurum_slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kurumEmail')
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
            'index' => Pages\ListKurumlars::route('/'),
            'create' => Pages\CreateKurumlar::route('/create'),
            'edit' => Pages\EditKurumlar::route('/{record}/edit'),
        ];
    }
}
