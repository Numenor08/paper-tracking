<?php

namespace App\Filament\Resources\Papers\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PaperInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('status')
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
                TextEntry::make('publication'),
                TextEntry::make('index.name')->label('Index'),
                TextEntry::make('abstract')->columnSpanFull(),
                TextEntry::make('note')->placeholder('-'),
                RepeatableEntry::make('contributorPapers')
                    ->label('Contributors')
                    ->schema([
                        TextEntry::make('contributor.full_name')->label('Name'),
                        TextEntry::make('role')
                            ->badge()
                            ->formatStateUsing(fn (?string $state): array => filled($state) ? explode('|', $state) : []),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
