<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class RadarConvocatorias extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-signal';
    protected static ?string $navigationLabel = 'Radar de Convocatorias (API)';
    protected static ?string $title = 'Radar de Convocatorias Internacionales';
    protected static ?string $navigationGroup = 'Contenido';
    protected static ?string $navigationBadge = 'API ACTIVA';
    protected static ?string $navigationBadgeTooltip = 'Sincronización continua de oportunidades';
    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.radar-convocatorias';

    public static function getNavigationBadgeColor(): string | array | null
    {
        return 'success';
    }
}
