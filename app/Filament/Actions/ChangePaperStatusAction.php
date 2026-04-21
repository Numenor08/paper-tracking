<?php

namespace App\Filament\Actions;

use App\Mail\PaperStatusChangedMail;
use App\Models\Paper;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ChangePaperStatusAction
{
    public static function make(): Action
    {
        return Action::make('changeStatus')
            ->label('Ubah Status')
            ->icon('heroicon-m-arrow-path')
            ->color('warning')
            ->schema([
                Select::make('new_status')
                    ->label('Status Baru')
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
                    ->required()
                    ->disableOptionWhen(
                        fn ($value, $state, Paper $record) => $value === $record->status
                    ),
            ])
            ->action(function (Paper $record, array $data) {
                $user = Auth::user();
                if (! $user instanceof User) {
                    return;
                }

                self::execute($record, $data['new_status'], $user);
            })
            ->successNotificationTitle('Status berhasil diperbarui!');
    }

    public static function execute(Paper $record, string $newStatus, User $user): void
    {
        $oldStatus = $record->status;

        if ($oldStatus === $newStatus) {
            return;
        }

        $history = $record->statusHistories()->create([
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'changed_by' => $user->id,
            'changed_at' => now(),
        ]);

        $record->update([
            'status' => $newStatus,
        ]);

        $emails = $record->contributors()
            ->whereNotNull('email')
            ->pluck('email')
            ->filter()
            ->unique()
            ->values()
            ->all();

        if ($emails === []) {
            return;
        }

        Mail::to($emails)->queue(new PaperStatusChangedMail($history));
    }
}
