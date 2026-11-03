<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConvocatoriaResource\Pages;
use App\Models\Convocatoria;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ConvocatoriaResource extends Resource
{
    protected static ?string $model = Convocatoria::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $navigationLabel = 'Radar Convocatorias';
    protected static ?string $modelLabel = 'Convocatoria';
    protected static ?string $pluralModelLabel = 'Convocatorias';
    protected static ?string $navigationGroup = 'Contenido';
    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        $sectoresOpciones = [
            'Gobierno nacional',
            'Gobierno subnacional',
            'ONG/Tercer sector',
            'Sector privado/PYMES',
            'Universidades/I+D',
            'Organismos multilaterales',
        ];

        return $form
            ->schema([
                Forms\Components\Section::make('Información Principal')->schema([
                    Forms\Components\TextInput::make('titulo')
                        ->label('Título de la Convocatoria')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('organismo')
                        ->label('Organismo / Entidad Convocante (Opcional)')
                        ->placeholder('Ej: FONTAGRO, ONU Mujeres, Comisión Europea...')
                        ->maxLength(255),

                    Forms\Components\Select::make('modalidad')
                        ->label('Modalidad')
                        ->options([
                            'No reembolsable' => 'No reembolsable',
                            'Préstamo' => 'Préstamo',
                            'Asistencia técnica' => 'Asistencia técnica',
                            'Mixto' => 'Mixto',
                            'Fondo Concursable' => 'Fondo Concursable',
                            'Cooperación Bilateral' => 'Cooperación Bilateral',
                        ])
                        ->searchable(),

                    Forms\Components\Textarea::make('resumen')
                        ->label('Resumen / Descripción')
                        ->rows(4)
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('requisitos')
                        ->label('Criterios de Elegibilidad / Requisitos (Opcional)')
                        ->placeholder('Si se deja vacío, en el modal del Radar se mostrarán automáticamente los sectores y beneficiarios elegibles.')
                        ->rows(3)
                        ->columnSpanFull(),
                ])->columns(2),

                Forms\Components\Section::make('Fechas y Presupuesto')->schema([
                    Forms\Components\DatePicker::make('fecha_public')
                        ->label('Fecha de Publicación'),

                    Forms\Components\DatePicker::make('fecha_limite')
                        ->label('Fecha Límite de Cierre'),

                    Forms\Components\TextInput::make('presup_texto')
                        ->label('Monto en Texto (Prioritario en tarjeta)')
                        ->placeholder('Ej: Hasta USD 250.000'),

                    Forms\Components\TextInput::make('moneda')
                        ->label('Moneda')
                        ->placeholder('USD / EUR'),

                    Forms\Components\TextInput::make('presupuesto_min')
                        ->label('Presupuesto Mínimo')
                        ->numeric(),

                    Forms\Components\TextInput::make('presupuesto_max')
                        ->label('Presupuesto Máximo')
                        ->numeric(),
                ])->columns(3),

                Forms\Components\Section::make('Alcance, Sectores y ODS')->schema([
                    Forms\Components\Select::make('alcance_region')
                        ->label('Alcance Regional')
                        ->options([
                            'Argentina' => 'Argentina',
                            'ALC' => 'ALC (Latinoamérica y el Caribe)',
                            'Fuera de región' => 'Fuera de región',
                        ]),

                    Forms\Components\TextInput::make('ambito_geo')
                        ->label('Ámbito Geográfico')
                        ->placeholder('Ej: Regional, Global, Bilateral...'),

                    Forms\Components\Toggle::make('alcance_arg')
                        ->label('¿Elegible para Argentina? 🇦🇷')
                        ->default(false)
                        ->inline(false),

                    Forms\Components\TagsInput::make('sector_elegible')
                        ->label('Sectores Elegibles')
                        ->suggestions($sectoresOpciones)
                        ->placeholder('Agregar sector...'),

                    Forms\Components\TagsInput::make('tipo_benef')
                        ->label('Tipos de Beneficiario')
                        ->suggestions($sectoresOpciones)
                        ->placeholder('Agregar beneficiario...'),

                    Forms\Components\TagsInput::make('ods')
                        ->label('Objetivos de Desarrollo Sostenible (ODS)')
                        ->placeholder('Ej: ODS 13 - Acción por el clima')
                        ->columnSpanFull(),
                ])->columns(3),

                Forms\Components\Section::make('Publicación y Control de Ingesta (n8n / IA)')->schema([
                    Forms\Components\Toggle::make('is_published')
                        ->label('¿Publicada en la web (/radar)?')
                        ->default(true),

                    Forms\Components\Toggle::make('requiere_revision_vigencia')
                        ->label('¿Requiere revisión de vigencia?')
                        ->default(false),

                    Forms\Components\Toggle::make('error_parseo')
                        ->label('¿Marcada con error de parseo IA?')
                        ->default(false),

                    Forms\Components\TextInput::make('score_conf')
                        ->label('Confianza IA (0.00 a 1.00)')
                        ->numeric()
                        ->step(0.01),

                    Forms\Components\TextInput::make('link')
                        ->label('URL / Fuente Oficial (Opcional)')
                        ->url()
                        ->maxLength(500)
                        ->columnSpan(2),

                    Forms\Components\Textarea::make('texto_crudo')
                        ->label('Texto Crudo de Respaldo (Solo en caso de fallo de parseo en n8n)')
                        ->rows(3)
                        ->columnSpanFull(),
                ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo')
                    ->label('Convocatoria')
                    ->searchable()
                    ->wrap()
                    ->description(fn (Convocatoria $record): string => $record->organismo ?: ($record->presup_texto ?: 'Sin organismo')),

                Tables\Columns\TextColumn::make('modalidad')
                    ->label('Modalidad')
                    ->badge()
                    ->color('info')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('alcance_region')
                    ->label('Región')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'Argentina' => 'success',
                        'ALC' => 'primary',
                        'Fuera de región' => 'gray',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('alcance_arg')
                    ->label('Arg 🇦🇷')
                    ->boolean(),

                Tables\Columns\TextColumn::make('fecha_limite')
                    ->label('Cierre')
                    ->date('d/m/Y')
                    ->placeholder('Abierta')
                    ->sortable(),

                Tables\Columns\IconColumn::make('requiere_revision_vigencia')
                    ->label('Rev. Vig.')
                    ->boolean()
                    ->trueIcon('heroicon-o-exclamation-triangle')
                    ->falseIcon('heroicon-o-check-circle')
                    ->trueColor('warning')
                    ->falseColor('success'),

                Tables\Columns\TextColumn::make('score_conf')
                    ->label('Confianza')
                    ->badge()
                    ->color(fn ($state): string => $state === null ? 'gray' : ($state >= 0.8 ? 'success' : ($state >= 0.5 ? 'warning' : 'danger'))),

                Tables\Columns\ToggleColumn::make('is_published')
                    ->label('Publicada'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Publicadas en Web'),
                Tables\Filters\TernaryFilter::make('alcance_arg')
                    ->label('Elegible Argentina'),
                Tables\Filters\TernaryFilter::make('requiere_revision_vigencia')
                    ->label('Requiere Revisión de Vigencia'),
                Tables\Filters\TernaryFilter::make('error_parseo')
                    ->label('Con Error de Parseo IA'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('descartar')
                    ->label('Descartar')
                    ->icon('heroicon-o-no-symbol')
                    ->color('danger')
                    ->visible(fn (Convocatoria $record): bool => $record->is_published)
                    ->action(fn (Convocatoria $record) => $record->update(['is_published' => false])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('publicar_seleccionadas')
                        ->label('Publicar seleccionadas')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(fn (\Illuminate\Database\Eloquent\Collection $records) => $records->each->update(['is_published' => true])),
                    Tables\Actions\BulkAction::make('descartar_seleccionadas')
                        ->label('Descartar seleccionadas (Ocultar)')
                        ->icon('heroicon-o-eye-slash')
                        ->color('warning')
                        ->action(fn (\Illuminate\Database\Eloquent\Collection $records) => $records->each->update(['is_published' => false])),
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
            'index' => Pages\ListConvocatorias::route('/'),
            'create' => Pages\CreateConvocatoria::route('/create'),
            'edit' => Pages\EditConvocatoria::route('/{record}/edit'),
        ];
    }
}
