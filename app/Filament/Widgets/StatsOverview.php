<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\ContactMessage;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $publishedArticles = Article::where('is_published', true)->count();
        $totalMessages = ContactMessage::count();

        return [
            Stat::make('Perspectivas Publicadas', $publishedArticles)
                ->description('Artículos y análisis activos')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Mensajes Recibidos', $totalMessages)
                ->description('Consultas vía web registradas')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('info'),

            Stat::make('Clientes Activos', '18')
                ->description('+3 incorporados este mes')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->chart([8, 11, 13, 14, 16, 18])
                ->color('success'),

            Stat::make('Proyectos Globales', '24')
                ->description('14 en ejecución · 10 completados')
                ->descriptionIcon('heroicon-m-globe-americas')
                ->chart([4, 9, 13, 17, 20, 24])
                ->color('primary'),

            Stat::make('Misiones Estratégicas', '6')
                ->description('2 agendas activas en curso')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('warning'),

            Stat::make('Tasa de Éxito', '98.5%')
                ->description('Cumplimiento de objetivos')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
        ];
    }
}
