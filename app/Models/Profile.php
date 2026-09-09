<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Single-row site profile. Everything the hero, about, contact card and
 * footer read, so all of it is editable from the admin panel.
 */
class Profile extends Model
{
    protected $guarded = [];

    protected $casts = [
        'stats'        => 'array',
        'is_available' => 'boolean',
    ];

    protected static ?self $current = null;

    /** Memoised: several partials ask for the profile in one request. */
    public static function current(): self
    {
        return static::$current ??= static::query()->firstOrNew([]);
    }

    /** Headline stored one line per row, so the hero can mask each separately. */
    public function getHeadlineLinesAttribute(): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $this->headline))
            ->map(fn ($l) => trim($l))
            ->filter()
            ->values()
            ->all();
    }

    public function getDomainAttribute(): string
    {
        return $this->root_domain ?: config('portfolio.domain');
    }
}
