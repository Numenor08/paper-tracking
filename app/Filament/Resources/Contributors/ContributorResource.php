<?php

namespace App\Filament\Resources\Contributors;

use App\Filament\Resources\Contributors\Pages\CreateContributor;
use App\Filament\Resources\Contributors\Pages\EditContributor;
use App\Filament\Resources\Contributors\Pages\ListContributors;
use App\Filament\Resources\Contributors\Schemas\ContributorForm;
use App\Filament\Resources\Contributors\Tables\ContributorsTable;
use App\Models\Contributor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContributorResource extends Resource
{
    protected static ?string $model = Contributor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ContributorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContributorsTable::configure($table);
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
            'index' => ListContributors::route('/'),
            'create' => CreateContributor::route('/create'),
            'edit' => EditContributor::route('/{record}/edit'),
        ];
    }
}
