<?php

namespace App\Filament\Resources\Papers\Pages;

use App\Filament\Resources\Papers\PaperResource;
use App\Mail\PaperStatusChangedMail;
use App\Models\PaperStatusHistory;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EditPaper extends EditRecord
{
    protected static string $resource = PaperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $media = $this->record->getFirstMedia('paper_documents');

        $this->record->forceFill([
            'paper_media_id' => $media?->id,
        ])->saveQuietly();

        // if ($this->oldStatus === null || $this->newStatus === null || $this->oldStatus === $this->newStatus) {
        //     return;
        // }

        // $actorId = Auth::id();

        // if ($actorId === null) {
        //     return;
        // }

        // $history = PaperStatusHistory::query()->create([
        //     'paper_id' => $this->record->id,
        //     'old_status' => $this->oldStatus,
        //     'new_status' => $this->newStatus,
        //     'changed_by' => $actorId,
        //     'changed_at' => now(),
        // ]);

        // $emails = $this->record->contributors()
        //     ->whereNotNull('email')
        //     ->pluck('email')
        //     ->filter()
        //     ->unique()
        //     ->values()
        //     ->all();

        // if ($emails === []) {
        //     return;
        // }

        // Mail::to($emails)->queue(new PaperStatusChangedMail($history));
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    // protected function mutateFormDataBeforeSave(array $data): array
    // {
    //     $this->oldStatus = $this->record->status;
    //     $this->newStatus = $data['new_status'] ?? $this->record->status;

    //     $data['status'] = $this->newStatus;

    //     unset($data['new_status']);

    //     return $data;
    // }
}
