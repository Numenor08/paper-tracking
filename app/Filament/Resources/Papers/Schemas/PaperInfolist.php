<?php

namespace App\Filament\Resources\Papers\Schemas;

use App\Models\Paper;
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
                            ->formatStateUsing(fn (?string $state): string => filled($state) ? str_replace('|', ', ', $state) : '-'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                RepeatableEntry::make('urlAttachment')
                    ->label('URL Attachments')
                    ->schema([
                        TextEntry::make('label')->placeholder('-'),
                        TextEntry::make('url')
                            ->url(fn (?string $state): ?string => $state)
                            ->openUrlInNewTab(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                RepeatableEntry::make('document_card')
                    ->label('Document')
                    ->getStateUsing(function (Paper $record): array {
                        $media = $record->getFirstMedia('paper_documents');

                        if ($media === null) {
                            return [];
                        }

                        return [[
                            'name' => $media->file_name,
                            'size' => $media->human_readable_size,
                            'open_url' => route('papers.documents.preview', $record),
                            'download_url' => route('papers.documents.download', $record),
                        ]];
                    })
                    ->schema([
                        TextEntry::make('name')->label('File Name')->placeholder('-'),
                        TextEntry::make('size')->label('Size')->placeholder('-'),
                        TextEntry::make('open_url')
                            ->label('Open')
                            ->formatStateUsing(fn (?string $state): string => filled($state) ? 'Open document' : '-')
                            ->url(fn (?string $state): ?string => $state)
                            ->openUrlInNewTab(),
                        TextEntry::make('download_url')
                            ->label('Download')
                            ->formatStateUsing(fn (?string $state): string => filled($state) ? 'Download document' : '-')
                            ->url(fn (?string $state): ?string => $state)
                            ->openUrlInNewTab(),
                    ])
                    ->columns(2)
                    ->visible(fn (Paper $record): bool => $record->getFirstMedia('paper_documents') !== null)
                    ->columnSpanFull(),
                TextEntry::make('document_placeholder')
                    ->label('Document')
                    ->placeholder('Tidak ada dokumen')
                    ->visible(fn (Paper $record): bool => $record->getFirstMedia('paper_documents') === null)
                    ->columnSpanFull(),
            ]);
    }
}
