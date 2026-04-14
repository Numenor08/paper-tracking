<?php

namespace App\Filament\Widgets;

use App\Models\Paper;
use Filament\Widgets\ChartWidget;

class PaperPublishingStatusDistributionChart extends ChartWidget
{
    protected int|string|array $columnSpan = 1;

    protected ?string $heading = 'Publishing Status Distribution';

    protected ?string $description = 'All papers';

    protected function getType(): string
    {
        return 'doughnut';
    }

    /**
     * @return array<string, mixed>
     */
    protected function getData(): array
    {
        $statuses = [
            'DRAFT',
            'READY-TO-SUBMITTED',
            'SUBMITTED',
            'UNDER-REVIEW',
            'REVISION-REQUESTED',
            'ACCEPTED',
            'REJECTED',
            'PUBLISHED',
        ];

        $labels = [];
        $data = [];

        foreach ($statuses as $status) {
            $labels[] = ucwords(strtolower(str_replace('-', ' ', $status)));
            $data[] = Paper::query()->where('status', $status)->count();
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Papers',
                    'data' => $data,
                    'backgroundColor' => [
                        '#6b7280',
                        '#06b6d4',
                        '#3b82f6',
                        '#f59e0b',
                        '#ef4444',
                        '#22c55e',
                        '#dc2626',
                        '#16a34a',
                    ],
                ],
            ],
        ];
    }
}
