<?php

namespace App\Filament\Widgets;

use App\Models\Paper;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PaperStatsOverview extends StatsOverviewWidget
{
    protected int|string|array $columnSpan = 'full';

    protected ?string $heading = 'Paper Summary';

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        $startOfMonth = now()->startOfMonth();

        return [
            Stat::make('Total Paper', (string) Paper::query()->count())
                ->description('A total number of papers'),
            Stat::make('Submitted This Month', (string) Paper::query()
                ->where('status', 'SUBMITTED')
                ->where('updated_at', '>=', $startOfMonth)
                ->count())
                ->description('A total submitted this month'),
            Stat::make('Published This Month', (string) Paper::query()
                ->where('status', 'PUBLISHED')
                ->where('updated_at', '>=', $startOfMonth)
                ->count())
                ->description('A total published this month'),
            Stat::make('Waiting Decision', (string) Paper::query()
                ->whereIn('status', ['SUBMITTED', 'UNDER-REVIEW', 'REVISION-REQUESTED'])
                ->count())
                ->description('Papers that still submitted, under review, or waiting for revision'),
        ];
    }
}
