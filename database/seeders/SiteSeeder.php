<?php

namespace Database\Seeders;

use App\Models\Capability;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use Illuminate\Database\Seeder;

/**
 * Imports the profile, experience, education and capabilities from
 * config/portfolio.php into the tables the admin panel edits.
 *
 * Safe to re-run: the profile is a single row, and the rest match on a
 * natural key rather than inserting duplicates.
 */
class SiteSeeder extends Seeder
{
    public function run(): void
    {
        $identity = config('portfolio.identity');
        $hero     = config('portfolio.hero');
        $contact  = config('portfolio.contact');
        $creds    = config('portfolio.credentials');

        Profile::updateOrCreate(
            ['id' => 1],
            [
                'name'            => $identity['name'],
                'short_name'      => $identity['short'] ?? null,
                'role'            => $identity['role'],
                'location'        => $identity['location'] ?? null,
                'is_available'    => $identity['available'] ?? true,
                'availability'    => 'Open to work & contracts',
                'email'           => $identity['email'] ?? null,
                'phone'           => $identity['phone'] ?? null,
                'phone_tel'       => $identity['phone_tel'] ?? null,
                'github'          => $identity['github'] ?? null,
                'linkedin'        => $identity['linkedin'] ?? null,
                'employer'        => $identity['employer'] ?? null,
                'root_domain'     => config('portfolio.domain'),
                'headline'        => implode("\n", $hero['headline']),
                'accent_line'     => $hero['accent_line'] ?? 0,
                'bio'             => $hero['bio'] ?? null,
                'about'           => $identity['about'] ?? null,
                'contact_heading' => implode(' ', $contact['heading'] ?? []),
                'contact_body'    => $contact['body'] ?? null,
                'stats'           => $hero['stats'] ?? [],
            ]
        );

        foreach ($creds['experience'] ?? [] as $i => $role) {
            Experience::updateOrCreate(
                ['role' => $role['role'], 'organisation' => $role['org']],
                [
                    'place'        => $role['place'] ?? null,
                    'starts'       => $role['from'] ?? null,
                    'ends'         => $role['to'] ?? null,
                    'points'       => $role['points'] ?? [],
                    'is_published' => true,
                    'sort_order'   => $i,
                ]
            );
        }

        foreach ($creds['education'] ?? [] as $i => $item) {
            Education::updateOrCreate(
                ['award' => $item['award'], 'organisation' => $item['org']],
                [
                    'starts'       => $item['from'] ?? null,
                    'ends'         => $item['to'] ?? null,
                    'is_published' => true,
                    'sort_order'   => $i,
                ]
            );
        }

        foreach (config('portfolio.practice', []) as $i => $item) {
            Capability::updateOrCreate(
                ['label' => $item['label']],
                [
                    'title'        => $item['title'],
                    'body'         => $item['body'],
                    'is_published' => true,
                    'sort_order'   => $i,
                ]
            );
        }

        $this->command?->info(sprintf(
            'Seeded profile, %d roles, %d qualifications, %d capabilities.',
            Experience::count(),
            Education::count(),
            Capability::count()
        ));
    }
}
