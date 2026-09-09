<?php

namespace App\Filament\Resources\Experiences\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;

class ExperienceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('role')->required()->columnSpanFull(),
                TextInput::make('organisation')->required(),
                TextInput::make('place')->placeholder('Zahle, Lebanon'),

                TextInput::make('starts')
                    ->label('From')
                    ->placeholder('Dec 2024')
                    ->helperText('Free text - shown exactly as typed.'),

                TextInput::make('ends')
                    ->label('To')
                    ->placeholder('Aug 2026 or Present'),

                Repeater::make('points')
                    ->label('What you did')
                    ->simple(TextInput::make('point')->required())
                    ->reorderable()
                    ->columnSpanFull(),

                Toggle::make('is_published')->default(true),
                TextInput::make('sort_order')->numeric()->default(0),
            ]);
    }
}
