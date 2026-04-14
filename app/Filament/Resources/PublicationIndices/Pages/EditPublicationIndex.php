<?php

namespace App\Filament\Resources\PublicationIndices\Pages;

use App\Filament\Resources\PublicationIndices\PublicationIndexResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPublicationIndex extends EditRecord
{
    protected static string $resource = PublicationIndexResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
