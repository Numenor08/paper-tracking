<?php

namespace App\Filament\Widgets;

use App\Models\Paper;
use Filament\Widgets\ChartWidget;

class PaperSubmissionPublicationTrendChart extends ChartWidget
{
    protected int|string|array $columnSpan = 1;

    protected ?string $heading = 'Submission vs Publication';

    protected ?string $description = 'Last 6 months';

    protected function getType(): string
    {
        return 'line';
    }

    /**
     * @return array<string, mixed>
     */
    protected function getData(): array
    {
        $labels = [];
        $submissionData = [];
        $publicationData = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->startOfMonth()->subMonths($i);
            $nextMonth = $month->copy()->addMonth();

            $labels[] = $month->format('M Y');

            $submissionData[] = Paper::query()
                ->where('created_at', '>=', $month)
                ->where('created_at', '<', $nextMonth)
                ->count();

            $publicationData[] = Paper::query()
                ->where('status', 'PUBLISHED')
                ->where('updated_at', '>=', $month)
                ->where('updated_at', '<', $nextMonth)
                ->count();
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Submission',
                    'data' => $submissionData,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                ],
                [
                    'label' => 'Publication',
                    'data' => $publicationData,
                    'borderColor' => '#16a34a',
                    'backgroundColor' => 'rgba(22, 163, 74, 0.2)',
                ],
            ],
        ];
    }
}
