<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Mensajes Recibidos';
    protected static ?string $modelLabel = 'Mensaje';
    protected static ?string $pluralModelLabel = 'Mensajes';
    protected static ?string $navigationGroup = 'Contacto';

    // Desactivar la creación manual desde el panel
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos del Contacto')->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nombre')
                        ->disabled(),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->disabled(),
                    Forms\Components\TextInput::make('organizacion')
                        ->label('Organización / Empresa')
                        ->disabled(),
                    Forms\Components\TextInput::make('pais')
                        ->label('País')
                        ->disabled(),
                ])->columns(2),

                Forms\Components\Section::make('Consulta')->schema([
                    Forms\Components\TextInput::make('intereses')
                        ->label('Área de Interés')
                        ->disabled()
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('message')
                        ->label('Mensaje')
                        ->rows(5)
                        ->disabled()
                        ->columnSpanFull(),
                ]),

                Forms\Components\Section::make('Gestión Interna (Solo Admin)')->schema([
                    Forms\Components\Select::make('status')
                        ->label('Estado')
                        ->options([
                            'No leído' => 'No leído',
                            'Leído' => 'Leído',
                            'Respondido' => 'Respondido',
                        ])
                        ->default('No leído')
                        ->required(),
                    Forms\Components\Textarea::make('admin_notes')
                        ->label('Notas Internas')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nombre')->searchable(),
                Tables\Columns\TextColumn::make('organizacion')->label('Organización')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->copyable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'No leído' => 'danger',
                        'Leído' => 'warning',
                        'Respondido' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Recibido')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Revisar'),
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
            'index' => Pages\ListContactMessages::route('/'),
            // 'create' => Pages\CreateContactMessage::route('/create'), // Eliminamos la ruta de crear
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}
