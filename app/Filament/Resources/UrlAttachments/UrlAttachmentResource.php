<?php

namespace App\Filament\Resources\UrlAttachments;

use App\Filament\Resources\UrlAttachments\Pages\CreateUrlAttachment;
use App\Filament\Resources\UrlAttachments\Pages\EditUrlAttachment;
use App\Filament\Resources\UrlAttachments\Pages\ListUrlAttachments;
use App\Filament\Resources\UrlAttachments\Schemas\UrlAttachmentForm;
use App\Filament\Resources\UrlAttachments\Tables\UrlAttachmentsTable;
use App\Models\UrlAttachment;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class UrlAttachmentResource extends Resource
{
    protected static ?string $model = UrlAttachment::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-link';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return UrlAttachmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UrlAttachmentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canViewAny(): bool
    {
        $user = Auth::user();

        return $user instanceof User && $user->isAdmin();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUrlAttachments::route('/'),
            'create' => CreateUrlAttachment::route('/create'),
            'edit' => EditUrlAttachment::route('/{record}/edit'),
        ];
    }
}
