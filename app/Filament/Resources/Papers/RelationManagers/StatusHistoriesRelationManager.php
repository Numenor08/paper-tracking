<?php

namespace App\Filament\Resources\Papers\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StatusHistoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'statusHistories';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Riwayat Status Paper')
            ->defaultSort('changed_at', 'desc')
            ->defaultPaginationPageOption(10)
            ->paginated([10, 25, 50])
            ->modifyQueryUsing(function (Builder $query): Builder {
                return $query->with('changedBy')->latest('changed_at');
            })
            ->columns([
                TextColumn::make('changed_at')
                    ->label('Tanggal Perubahan')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('old_status')
                    ->label('Status Lama')
                    ->badge()
                    ->color(fn (string $state): string => static::statusColor($state)),
                TextColumn::make('new_status')
                    ->label('Status Baru')
                    ->badge()
                    ->color(fn (string $state): string => static::statusColor($state)),
                TextColumn::make('changedBy.name')
                    ->label('Diubah Oleh')
                    ->placeholder('Sistem'),
            ])
            ->striped();
    }

    private static function statusColor(string $state): string
    {
        return match ($state) {
            'DRAFT' => 'gray',
            'READY-TO-SUBMITTED' => 'info',
            'SUBMITTED' => 'primary',
            'UNDER-REVIEW' => 'warning',
            'REVISION-REQUESTED' => 'danger',
            'ACCEPTED' => 'success',
            'REJECTED' => 'danger',
            'PUBLISHED' => 'success',
            default => 'gray',
        };
    }
}
