<?php

namespace App\Filament\Resources\Profiles\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Who you are')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')->required(),

                        TextInput::make('short_name')
                            ->helperText('Shown in the header next to the logo mark.'),

                        TextInput::make('role')
                            ->required()
                            ->columnSpanFull()
                            ->helperText('The job title under your name, e.g. "Full-Stack Developer & Systems Integration Engineer".'),

                        TextInput::make('location')->placeholder('Zahlé, Lebanon'),

                        TextInput::make('employer')
                            ->helperText('Referenced in the practice copy.'),

                        Toggle::make('is_available')
                            ->label('Available for work')
                            ->live()
                            ->helperText('Shows the pulsing dot in the hero.'),

                        TextInput::make('availability')
                            ->visible(fn ($get) => $get('is_available'))
                            ->placeholder('Open to work & contracts'),
                    ]),

                Section::make('Contact & links')
                    ->description('Used by the contact card, the footer and the header.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('email')->email(),

                        TextInput::make('phone')
                            ->helperText('Displayed as typed, e.g. "+961 70 535 819".'),

                        TextInput::make('phone_tel')
                            ->label('Phone (dial format)')
                            ->helperText('Digits only for the tel: link, e.g. "+96170535819".'),

                        TextInput::make('website')->url(),

                        TextInput::make('github')->url()->prefixIcon('heroicon-o-code-bracket'),

                        TextInput::make('linkedin')->url()->prefixIcon('heroicon-o-briefcase'),

                        TextInput::make('root_domain')
                            ->label('Root domain')
                            ->placeholder('mustafa.dev')
                            ->helperText('Project subdomains hang off this. Changing it moves every subdomain link at once.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Hero')
                    ->columns(2)
                    ->schema([
                        Textarea::make('headline')
                            ->rows(3)
                            ->required()
                            ->columnSpanFull()
                            ->helperText('One line per row. Each line slides up separately on load, so keep them short.'),

                        TextInput::make('accent_line')
                            ->numeric()
                            ->default(0)
                            ->helperText('Which line is coloured. 0 is the first line.'),

                        Textarea::make('bio')
                            ->rows(4)
                            ->columnSpanFull()
                            ->helperText('The paragraph under the headline.'),

                        Repeater::make('stats')
                            ->label('Stat tiles')
                            ->columns(2)
                            ->reorderable()
                            ->columnSpanFull()
                            ->schema([
                                TextInput::make('label')->required(),
                                TextInput::make('value')
                                    ->required()
                                    ->helperText('A leading number counts up on view, e.g. "27 projects".'),
                            ]),
                    ]),

                Section::make('About')
                    ->schema([
                        Textarea::make('about')
                            ->rows(6)
                            ->helperText('The longer personal statement in the track record section.'),
                    ]),

                Section::make('Contact section')
                    ->schema([
                        TextInput::make('contact_heading')->columnSpanFull(),
                        Textarea::make('contact_body')->rows(3)->columnSpanFull(),
                    ]),
            ]);
    }
}
