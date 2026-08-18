<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Imports the content in config/portfolio.php into the projects table.
 *
 * The config file stays the source of truth for a fresh install; once the site
 * is running, Filament owns the data. Re-running this seeder updates rows by
 * slug rather than duplicating them, so it is safe to run again.
 */
class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $board     = collect(config('portfolio.board'))->keyBy('host');
        $spotlight = collect(config('portfolio.spotlight'))->keyBy('host');

        $seeded = [];

        foreach (config('portfolio.projects') as $index => $row) {
            $slug = Str::slug($row['name']);
            $host = $row['host'] ?? null;

            $attributes = [
                'name'         => $row['name'],
                'category'     => $row['category'],
                'kind'         => $row['kind'],
                'summary'      => $row['summary'],
                'stack'        => $row['stack'],
                'status'       => $row['status'],
                'host'         => $host,
                'repo'         => $row['repo'],
                'sort_order'   => $index,
                'is_published' => true,
            ];

            // Hero deployment board
            if ($host && $board->has($host)) {
                $attributes['on_board']      = true;
                $attributes['board_summary'] = $board[$host]['summary'];
                $attributes['status']        = $board[$host]['status'];
            }

            // Spotlight case study
            if ($host && $spotlight->has($host)) {
                $case = $spotlight[$host];

                $attributes['is_spotlight'] = true;
                $attributes['tagline']      = $case['tagline'];
                $attributes['problem']      = $case['problem'];
                $attributes['solution']     = $case['solution'];
                $attributes['points']       = $case['points'];
                $attributes['tech']         = $case['stack'];
                $attributes['flow']         = $case['flow'];
                $attributes['media_first']  = $case['media_first'] ?? false;
            }

            Project::updateOrCreate(['slug' => $slug], $attributes);

            $seeded[] = $slug;
        }

        // Drop rows for projects that have since been removed from the config,
        // so re-running the seeder converges instead of accumulating orphans.
        $removed = Project::query()->whereNotIn('slug', $seeded)->delete();

        $this->command?->info("Seeded {$this->count($seeded)} projects, removed {$removed} stale.");
    }

    private function count(array $seeded): int
    {
        return count($seeded);
    }
}
