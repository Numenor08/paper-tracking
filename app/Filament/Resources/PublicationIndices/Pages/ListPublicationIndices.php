<?php

namespace App\Filament\Resources\PublicationIndices\Pages;

use App\Filament\Resources\PublicationIndices\PublicationIndexResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPublicationIndices extends ListRecords
{
    protected static string $resource = PublicationIndexResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
