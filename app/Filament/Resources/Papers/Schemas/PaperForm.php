<?php

namespace App\Filament\Resources\Papers\Schemas;

use App\Models\ContributorPaper;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaperForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Select::make('status')
                    ->options([
                        'DRAFT' => 'DRAFT',
                        'READY-TO-SUBMITTED' => 'READY-TO-SUBMITTED',
                        'SUBMITTED' => 'SUBMITTED',
                        'UNDER-REVIEW' => 'UNDER-REVIEW',
                        'REVISION-REQUESTED' => 'REVISION-REQUESTED',
                        'ACCEPTED' => 'ACCEPTED',
                        'REJECTED' => 'REJECTED',
                        'PUBLISHED' => 'PUBLISHED',
                    ])
                    ->required(),
                TextInput::make('publication')
                    ->required()
                    ->maxLength(255),
                Select::make('publication_index_id')
                    ->relationship('index', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Repeater::make('contributorPapers')
                    ->relationship('contributorPapers')
                    ->schema([
                        Select::make('contributor_id')
                            ->relationship('contributor', 'full_name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Select::make('role')
                            ->options(ContributorPaper::ROLE_OPTIONS)
                            ->multiple()
                            ->afterStateHydrated(function (Select $component, mixed $state): void {
                                if (is_string($state) && filled($state)) {
                                    $component->state(explode('|', $state));
                                }
                            })
                            ->dehydrateStateUsing(fn (mixed $state): ?string => is_array($state) ? implode('|', $state) : $state)
                            ->required(),
                    ])
                    ->columns(2)
                    ->defaultItems(0)
                    ->addActionLabel('Tambah Contributor')
                    ->columnSpanFull(),
                Textarea::make('abstract')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('note')
                    ->maxLength(255),
                SpatieMediaLibraryFileUpload::make('document')
                    ->collection('paper_documents')
                    ->acceptedFileTypes([
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    ])
                    ->downloadable()
                    ->openable()
                    ->maxFiles(1)
                    ->columnSpanFull(),
            ]);
    }
}
