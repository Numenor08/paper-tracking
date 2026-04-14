<?php

namespace App\Filament\Resources\Papers\Pages;

use App\Filament\Resources\Papers\PaperResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePaper extends CreateRecord
{
    protected static string $resource = PaperResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth::id();

        return $data;
    }

    protected function afterCreate(): void
    {
        $media = $this->record->getFirstMedia('paper_documents');

        $this->record->forceFill([
            'paper_media_id' => $media?->id,
        ])->saveQuietly();
    }
}
