<?php

namespace App\Filament\Resources\Papers\Tables;

use App\Models\PublicationIndex;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PapersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status')
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
                    })
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Artikel')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('publication')
                    ->searchable(),
                TextColumn::make('index.name')
                    ->label('Index')
                    ->sortable(),
                TextColumn::make('media_count')
                    ->label('Documents')
                    ->counts('media'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'DRAFT' => 'DRAFT',
                        'READY-TO-SUBMITTED' => 'READY-TO-SUBMITTED',
                        'SUBMITTED' => 'SUBMITTED',
                        'UNDER-REVIEW' => 'UNDER-REVIEW',
                        'REVISION-REQUESTED' => 'REVISION-REQUESTED',
                        'ACCEPTED' => 'ACCEPTED',
                        'REJECTED' => 'REJECTED',
                        'PUBLISHED' => 'PUBLISHED',
                    ]),
                SelectFilter::make('publication_index_id')
                    ->label('Index')
                    ->options(PublicationIndex::query()->pluck('name', 'id')->all()),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
