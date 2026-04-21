<?php

namespace App\Filament\Resources\PublicationIndices;

use App\Filament\Resources\PublicationIndices\Pages\ListPublicationIndices;
use App\Filament\Resources\PublicationIndices\Schemas\PublicationIndexForm;
use App\Filament\Resources\PublicationIndices\Tables\PublicationIndicesTable;
use App\Models\PublicationIndex;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PublicationIndexResource extends Resource
{
    protected static ?string $model = PublicationIndex::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Publication Index';

    protected static ?string $modelLabel = 'Publication Index';

    protected static ?string $pluralModelLabel = 'Publication Index';

    public static function form(Schema $schema): Schema
    {
        return PublicationIndexForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PublicationIndicesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        $user = Auth::user();

        return $user instanceof User && $user->isAdmin();
    }

    public static function canEdit(Model $record): bool
    {
        $user = Auth::user();

        return $user instanceof User && $user->isAdmin();
    }

    public static function canDelete(Model $record): bool
    {
        $user = Auth::user();

        return $user instanceof User && $user->isAdmin();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPublicationIndices::route('/'),
        ];
    }
}
