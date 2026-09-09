<?php

namespace App\Filament\Resources\Documents\Schemas;

use App\Models\Document;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Document')
                    ->description('The CV appears in the contact card and the track record. Certificates are listed in the track record.')
                    ->columns(2)
                    ->schema([
                        Select::make('type')
                            ->required()
                            ->live()
                            ->default(Document::TYPE_CERTIFICATE)
                            ->options(Document::types())
                            ->helperText('Only the newest published CV is shown on the site.'),

                        TextInput::make('title')
                            ->required()
                            ->helperText('e.g. "Curriculum Vitae" or "AI Training Hackathon".'),

                        TextInput::make('issuer')
                            ->label('Issued by')
                            ->helperText('The awarding body, e.g. "Kanz AI · LAU ACE".'),

                        TextInput::make('date_label')
                            ->label('Date')
                            ->placeholder('July 2026')
                            ->visible(fn ($get) => $get('type') === Document::TYPE_CERTIFICATE)
                            ->helperText('Free text — shown exactly as typed.'),

                        TextInput::make('reference')
                            ->label('Credential ID')
                            ->visible(fn ($get) => $get('type') === Document::TYPE_CERTIFICATE)
                            ->helperText('Printed on the certificate, so it stays verifiable.')
                            ->columnSpanFull(),
                    ]),

                Section::make('File')
                    ->schema([
                        FileUpload::make('file')
                            ->label('PDF')
                            ->disk(Document::DISK)
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(8192)
                            ->downloadable()
                            ->openable()
                            // Keep the stored name readable — it becomes the
                            // public URL and people see it when downloading.
                            ->preserveFilenames()
                            ->helperText('PDF, up to 8 MB. Served from /documents.'),
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
