<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\PaperPublishingStatusDistributionChart;
use App\Filament\Widgets\PaperRecentStatusChangesTable;
use App\Filament\Widgets\PaperStatsOverview;
use App\Filament\Widgets\PaperSubmissionPublicationTrendChart;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\Widget;

class Dashboard extends BaseDashboard
{
    /**
     * @return array<class-string<Widget>>
     */
    public function getWidgets(): array
    {
        return [
            PaperStatsOverview::class,
            PaperSubmissionPublicationTrendChart::class,
            PaperPublishingStatusDistributionChart::class,
            PaperRecentStatusChangesTable::class,
        ];
    }

    /**
     * @return int | array<string, ?int>
     */
    public function getColumns(): int|array
    {
        return 2;
    }
}
