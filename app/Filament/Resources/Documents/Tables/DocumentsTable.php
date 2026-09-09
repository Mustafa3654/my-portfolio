<?php

namespace App\Filament\Resources\Documents\Tables;

use App\Models\Document;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DocumentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Document::types()[$state] ?? $state)
                    ->color(fn ($state) => $state === Document::TYPE_CV ? 'warning' : 'info')
                    ->sortable(),

                TextColumn::make('title')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn ($record) => $record->issuer),

                TextColumn::make('date_label')
                    ->label('Date')
                    ->placeholder('—'),

                TextColumn::make('reference')
                    ->label('Credential ID')
                    ->placeholder('—')
                    ->copyable()
                    ->toggleable(),

                TextColumn::make('file')
                    ->label('File')
                    ->state(fn ($record) => $record->file ?: 'No file')
                    ->url(fn ($record) => $record->url)
                    ->openUrlInNewTab()
                    ->color(fn ($record) => $record->url ? 'primary' : 'danger'),

                IconColumn::make('is_published')
                    ->label('Live on site')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')->options(Document::types()),
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
