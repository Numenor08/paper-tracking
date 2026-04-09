<?php

namespace App\Filament\Resources\Contributors\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContributorForm
{
    // ... import komponen TextInput, Textarea, Section ...
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('full_name')->required(),
            TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
            TextInput::make('affiliation'),
            TextInput::make('phone_number')->tel(),
            Textarea::make('address')->columnSpanFull(),
        ]);
    }
}
