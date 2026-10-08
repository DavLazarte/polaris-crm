<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ClientCrm extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Gestión de Clientes (CRM)';
    protected static ?string $title = 'Clientes & Proyectos Internacionales';
    protected static ?string $navigationGroup = 'Gestión Internacional';
    protected static ?string $navigationBadge = 'PROTOTIPO';
    protected static ?string $navigationBadgeTooltip = 'Simulación interactiva del flujo Airtable';
    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.client-crm';

    public static function getNavigationBadgeColor(): string | array | null
    {
        return 'primary';
    }
}
