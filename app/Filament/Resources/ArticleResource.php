<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Concerns\Translatable;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    use Translatable;

    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Perspectivas';
    protected static ?string $modelLabel = 'Noticia';
    protected static ?string $pluralModelLabel = 'Noticias';
    protected static ?string $navigationGroup = 'Contenido';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información Principal')->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Título')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                        
                    Forms\Components\TextInput::make('slug')
                        ->label('URL Amigable (Slug)')
                        ->required()
                        ->unique(ignoreRecord: true),
                        
                    Forms\Components\Select::make('category')
                        ->label('Categoría')
                        ->options([
                            'Comercio Exterior' => 'Comercio Exterior',
                            'Casos de Éxito' => 'Casos de Éxito',
                            'Cooperación Internacional' => 'Cooperación Internacional',
                            'Marco Regulatorio' => 'Marco Regulatorio',
                        ])
                        ->required(),
                ])->columns(2),

                Forms\Components\Section::make('Contenido y Multimedia')->schema([
                    Forms\Components\FileUpload::make('img')
                        ->label('Imagen Principal')
                        ->image()
                        ->directory('articles')
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('excerpt')
                        ->label('Bajada / Extracto (Para las tarjetas)')
                        ->rows(3)
                        ->columnSpanFull(),

                    Forms\Components\RichEditor::make('body')
                        ->label('Cuerpo completo de la noticia')
                        ->required()
                        ->columnSpanFull(),
                ]),

                Forms\Components\Section::make('Publicación')->schema([
                    Forms\Components\Toggle::make('is_published')
                        ->label('¿Publicar? (Visible en la web)')
                        ->default(true),

                    Forms\Components\Toggle::make('is_featured')
                        ->label('¿Destacar? (Aparecerá grande arriba)')
                        ->default(false),
                        
                    Forms\Components\DatePicker::make('published_at')
                        ->label('Fecha de Publicación')
                        ->default(now()),
                ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('img')->label('Imagen'),
                Tables\Columns\TextColumn::make('title')->label('Título')->searchable(),
                Tables\Columns\TextColumn::make('category')->label('Categoría')->sortable(),
                Tables\Columns\IconColumn::make('is_published')->label('Publicada')->boolean(),
                Tables\Columns\IconColumn::make('is_featured')->label('Destacada')->boolean(),
                Tables\Columns\TextColumn::make('published_at')->label('Fecha')->date('d/m/Y')->sortable(),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
