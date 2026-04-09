<?php

namespace App\Filament\Resources\Contributors\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContributorsTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('full_name')->searchable()->sortable(),
            TextColumn::make('email')->searchable(),
            TextColumn::make('affiliation'),
            TextColumn::make('created_at')->dateTime()->sortable(),
        ]);
    }
}
