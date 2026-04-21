<?php

namespace App\Filament\Resources\UrlAttachments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UrlAttachmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('paper_id')
                    ->relationship('paper', 'title')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('label')
                    ->maxLength(255),
                TextInput::make('url')
                    ->required()
                    ->url()
                    ->maxLength(2048)
                    ->columnSpanFull(),
            ]);
    }
}
