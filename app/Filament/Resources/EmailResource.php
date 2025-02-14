<?php

namespace App\Filament\Resources;

use AbdelhamidErrahmouni\FilamentMonacoEditor\MonacoEditor;
use App\Filament\Resources\EmailResource\Pages;
use App\Filament\Resources\EmailResource\RelationManagers;
use App\Models\Email;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class EmailResource extends Resource
{
    protected static ?string $model = Email::class;
    protected static ?string $navigationLabel = 'E-posta Şablonları';
    protected static ?string $slug = 'mailler';
    protected static ?string $label = 'Email Şablonu';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-document-plus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Section::make([
                        Forms\Components\TextInput::make('subject')
                            ->required()
                            ->maxLength(255)->label('Başlık'),
                    ]),
                    Forms\Components\Section::make([
                        Radio::make('mailtercihi')->options([
                            'html' => 'HTML kodu yaz',
                            'make' => 'Kendin yaz'
                        ])->label('Editör Tercihi')->default('html')->required()->live(),
                    ])->grow(false),

                ])->columnSpanFull(),

                // Forms\Components\RichEditor::make('body')->columnSpanFull(),
                //Forms\Components\MarkdownEditor::make('body'),
                TinyEditor::make('body')->columnSpanFull()->language('tr')->visible(fn(Get $get) => $get('mailtercihi') == 'make')->label('Mail İçeriği')->required(),
                MonacoEditor::make('body')->language('html')->columnSpanFull()->visible(fn(Get $get) => $get('mailtercihi') == 'html')->label('Mail İçeriği')->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subject')
                    ->searchable()->label('Email Başlığı'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)->label('Oluşturma Tarihi'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)->label('Güncellenme Tarihi'),
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
            //RelationManagers\KurumRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmails::route('/'),
            'create' => Pages\CreateEmail::route('/create'),
            'edit' => Pages\EditEmail::route('/{record}/edit'),
        ];
    }
}
