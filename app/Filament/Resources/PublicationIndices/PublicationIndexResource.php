<?php

namespace App\Filament\Resources\PublicationIndices;

use App\Filament\Resources\PublicationIndices\Pages\ListPublicationIndices;
use App\Filament\Resources\PublicationIndices\Schemas\PublicationIndexForm;
use App\Filament\Resources\PublicationIndices\Tables\PublicationIndicesTable;
use App\Models\PublicationIndex;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PublicationIndexResource extends Resource
{
    protected static ?string $model = PublicationIndex::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

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

    public static function getPages(): array
    {
        return [
            'index' => ListPublicationIndices::route('/'),
        ];
    }
}
