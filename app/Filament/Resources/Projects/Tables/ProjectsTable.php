<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use App\Models\Project;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('category')
                    ->badge()
                    ->formatStateUsing(fn ($state) => config('portfolio.categories')[$state] ?? $state)
                    ->color(fn ($state) => match ($state) {
                        'apps'     => 'info',
                        'commerce' => 'success',
                        'tools'    => 'warning',
                        default    => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'live', 'in-use' => 'success',
                        'beta', 'wip'    => 'warning',
                        'complete'       => 'info',
                        default          => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('display_host')
                    ->label('Address')
                    ->state(fn ($record) => $record->display_host ?? '—')
                    ->description(fn ($record) => Project::linkTypes()[$record->link_type] ?? null)
                    ->url(fn ($record) => $record->live_url)
                    ->openUrlInNewTab()
                    ->color(fn ($record) => $record->live_url ? 'primary' : 'gray'),

                TextColumn::make('stack')
                    ->limit(30)
                    ->toggleable(),

                IconColumn::make('on_board')
                    ->label('Board')
                    ->boolean()
                    ->sortable(),

                IconColumn::make('is_spotlight')
                    ->label('Spotlight')
                    ->boolean()
                    ->sortable(),

                IconColumn::make('is_published')
                    ->label('Live on site')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')->options(config('portfolio.categories')),

                SelectFilter::make('link_type')->label('Address type')->options(Project::linkTypes()),

                SelectFilter::make('status')->options([
                    'live'    => 'Live',
                    'in-use'  => 'In use',
                    'beta'    => 'Beta',
                    'wip'     => 'In progress',
                    'complete' => 'Complete',
                    'private' => 'Private',
                ]),

                TernaryFilter::make('on_board')->label('On deployment board'),
                TernaryFilter::make('is_spotlight')->label('Spotlight case study'),
                TernaryFilter::make('is_published')->label('Published'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
