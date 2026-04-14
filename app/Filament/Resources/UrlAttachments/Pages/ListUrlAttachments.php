<?php

namespace App\Filament\Resources\UrlAttachments\Pages;

use App\Filament\Resources\UrlAttachments\UrlAttachmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUrlAttachments extends ListRecords
{
    protected static string $resource = UrlAttachmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
