<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;

/**
 * Imports the CV and certifications from config/portfolio.php.
 *
 * Matches on title so re-running updates rather than duplicating. Files are
 * already sitting on the `documents` disk (public/documents), so only the
 * basename is stored.
 */
class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        $identity = config('portfolio.identity');

        if (! empty($identity['cv'])) {
            Document::updateOrCreate(
                ['type' => Document::TYPE_CV, 'title' => 'Curriculum Vitae'],
                [
                    'issuer'       => $identity['name'] ?? null,
                    'file'         => basename($identity['cv']),
                    'is_published' => true,
                    'sort_order'   => 0,
                ]
            );
        }

        foreach (config('portfolio.credentials.certifications', []) as $i => $cert) {
            Document::updateOrCreate(
                ['type' => Document::TYPE_CERTIFICATE, 'title' => $cert['award']],
                [
                    'issuer'       => $cert['org'] ?? null,
                    'date_label'   => $cert['date'] ?? null,
                    'reference'    => $cert['id'] ?? null,
                    'file'         => ! empty($cert['file']) ? basename($cert['file']) : null,
                    'is_published' => true,
                    'sort_order'   => $i,
                ]
            );
        }

        $this->command?->info('Seeded '.Document::count().' documents.');
    }
}
