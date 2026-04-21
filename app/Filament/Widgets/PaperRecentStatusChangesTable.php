<?php

namespace App\Filament\Widgets;

use App\Models\PaperStatusHistory;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Support\Facades\Auth;

class PaperRecentStatusChangesTable extends TableWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Recent Status Change')
            ->query(PaperStatusHistory::query()->with(['paper', 'changedBy'])->visibleTo(Auth::user())->latest('changed_at'))
            ->defaultPaginationPageOption(5)
            ->columns([
                Tables\Columns\TextColumn::make('paper.title')
                    ->label('Artikel')
                    ->searchable(),
                Tables\Columns\TextColumn::make('old_status')
                    ->label('From')
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
                Tables\Columns\TextColumn::make('new_status')
                    ->label('To')
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
                Tables\Columns\TextColumn::make('changedBy.name')
                    ->label('Changed By')
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('changed_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('paper.publication')
                    ->label('Publication')
                    ->searchable(),
            ]);
    }
}
