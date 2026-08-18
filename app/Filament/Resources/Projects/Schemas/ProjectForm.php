<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Project')
                    ->description('Shown on the work grid.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug((string) $state))),

                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Used as the record key. Generated from the name.'),

                        Select::make('category')
                            ->required()
                            ->default('apps')
                            ->options(config('portfolio.categories'))
                            ->helperText('Which filter chip this card appears under.'),

                        TextInput::make('kind')
                            ->required()
                            ->default('Web app')
                            ->helperText('Small label on the card, e.g. "Digital menu".'),

                        Textarea::make('summary')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        TextInput::make('stack')
                            ->helperText('Free text, middot separated: Laravel · Filament · MySQL'),

                        Select::make('status')
                            ->required()
                            ->default('live')
                            ->options([
                                'live'    => 'Live',
                                'in-use'  => 'In use',
                                'beta'    => 'Beta',
                                'wip'     => 'In progress',
                                'private' => 'Private',
                            ])
                            ->helperText('Drives the status pill and the beta styling.'),
                    ]),

                Section::make('Links')
                    ->columns(2)
                    ->schema([
                        TextInput::make('host')
                            ->prefix('https://')
                            ->suffix('.'.config('portfolio.domain'))
                            ->helperText('Subdomain only. Leave empty if it is not deployed.'),

                        TextInput::make('repo')
                            ->url()
                            ->helperText('Full GitHub URL, or empty for private work.'),
                    ]),

                Section::make('Deployment board')
                    ->description('The hero table of live subdomains.')
                    ->columns(2)
                    ->schema([
                        Toggle::make('on_board')
                            ->live()
                            ->helperText('Show this project on the hero board.'),

                        TextInput::make('board_summary')
                            ->visible(fn ($get) => $get('on_board'))
                            ->helperText('Short line for the board. Falls back to the summary.'),
                    ]),

                Section::make('Spotlight case study')
                    ->description('The long-form problem and solution breakdown.')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_spotlight')->live(),

                        Toggle::make('media_first')
                            ->label('Diagram on the left')
                            ->visible(fn ($get) => $get('is_spotlight'))
                            ->helperText('Alternate this between spotlights for rhythm.'),

                        TextInput::make('tagline')
                            ->visible(fn ($get) => $get('is_spotlight'))
                            ->columnSpanFull(),

                        Textarea::make('problem')
                            ->rows(5)
                            ->visible(fn ($get) => $get('is_spotlight'))
                            ->columnSpanFull(),

                        Textarea::make('solution')
                            ->rows(5)
                            ->visible(fn ($get) => $get('is_spotlight'))
                            ->columnSpanFull(),

                        TagsInput::make('points')
                            ->label('Key points')
                            ->visible(fn ($get) => $get('is_spotlight'))
                            ->columnSpanFull(),

                        TagsInput::make('tech')
                            ->label('Tech chips')
                            ->visible(fn ($get) => $get('is_spotlight'))
                            ->columnSpanFull(),
                    ]),

                Section::make('Flow diagram')
                    ->description('The hairline diagram beside a spotlight case study.')
                    ->visible(fn ($get) => $get('is_spotlight'))
                    ->schema([
                        TextInput::make('flow.title')->label('Diagram title'),
                        TextInput::make('flow.note')->label('Caption'),

                        Repeater::make('flow.steps')
                            ->label('Steps')
                            ->reorderable()
                            ->columns(2)
                            ->schema([
                                TextInput::make('label')->required(),
                                Toggle::make('accent')->helperText('Highlight this step in brass.'),
                            ]),
                    ]),

                Section::make('Publishing')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_published')->default(true),
                        TextInput::make('sort_order')->required()->numeric()->default(0),
                    ]),
            ]);
    }
}
