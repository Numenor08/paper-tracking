<?php

namespace App\Filament\Resources\Papers;

use App\Filament\Resources\Papers\Pages\CreatePaper;
use App\Filament\Resources\Papers\Pages\EditPaper;
use App\Filament\Resources\Papers\Pages\ListPapers;
use App\Filament\Resources\Papers\Pages\ViewPaper;
use App\Filament\Resources\Papers\Schemas\PaperForm;
use App\Filament\Resources\Papers\Schemas\PaperInfolist;
use App\Filament\Resources\Papers\Tables\PapersTable;
use App\Models\Paper;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PaperResource extends Resource
{
    protected static ?string $model = Paper::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    public static function form(Schema $schema): Schema
    {
        return PaperForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PapersTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PaperInfolist::configure($schema);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->visibleTo(Auth::user());
    }

    public static function canView(Model $record): bool
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            return false;
        }

        return $user->isAdmin() || $record->created_by === $user->id;
    }

    public static function canEdit(Model $record): bool
    {
        return static::canView($record);
    }

    public static function canDelete(Model $record): bool
    {
        return static::canView($record);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPapers::route('/'),
            'create' => CreatePaper::route('/create'),
            'view' => ViewPaper::route('/{record}'),
            'edit' => EditPaper::route('/{record}/edit'),
        ];
    }
}
