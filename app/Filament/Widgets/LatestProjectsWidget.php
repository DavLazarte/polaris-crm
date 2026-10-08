<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class LatestProjectsWidget extends Widget
{
    protected static ?int $sort = 2;
    protected static string $view = 'filament.widgets.latest-projects';
    protected int | string | array $columnSpan = 'full';
}
