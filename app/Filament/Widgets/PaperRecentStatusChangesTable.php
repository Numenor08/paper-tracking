<?php

namespace App\Filament\Widgets;

use App\Models\Paper;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class PaperRecentStatusChangesTable extends TableWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Recent Status Change')
            ->query(Paper::query()->latest('updated_at'))
            ->defaultPaginationPageOption(5)
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Artikel')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'DRAFT' => 'gray',
                        'READY-TO-SUBMITTED' => 'info',
                        'SUBMITTED' => 'primary',
                        'UNDER-REVIEW' => 'warning',
                        'REVISION-REQUESTED' => 'danger',
                        'ACCEPTED' => 'success',
                        'REJECTED' => 'danger',
                        'PUBLISHED' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('publication')
                    ->searchable(),
            ]);
    }
}
