<?php

namespace App\Filament\Resources\UrlAttachments\Pages;

use App\Filament\Resources\UrlAttachments\UrlAttachmentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUrlAttachment extends EditRecord
{
    protected static string $resource = UrlAttachmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
