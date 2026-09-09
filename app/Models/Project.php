<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $guarded = [];

    protected $casts = [
        'points'       => 'array',
        'tech'         => 'array',
        'flow'         => 'array',
        'is_spotlight' => 'boolean',
        'media_first'  => 'boolean',
        'on_board'     => 'boolean',
        'is_published' => 'boolean',
    ];

    public const LINK_SUBDOMAIN = 'subdomain';
    public const LINK_DOMAIN    = 'domain';
    public const LINK_NONE      = 'none';

    public static function linkTypes(): array
    {
        return [
            self::LINK_SUBDOMAIN => 'Subdomain of my root domain',
            self::LINK_DOMAIN    => 'Its own domain',
            self::LINK_NONE      => 'Not deployed',
        ];
    }

    /**
     * The hostname as it should be shown and linked, with no scheme or path.
     *
     * Resolving this in one place means every view — board, cards, spotlight
     * headers — agrees on what a project's address is.
     */
    public function getDisplayHostAttribute(): ?string
    {
        return match ($this->link_type) {
            self::LINK_SUBDOMAIN => $this->host
                ? $this->host.'.'.config('portfolio.domain')
                : null,

            // Tolerate a pasted URL: strip scheme, any path, and a trailing dot.
            self::LINK_DOMAIN => $this->domain
                ? rtrim(Str::before(preg_replace('#^https?://#i', '', trim($this->domain)), '/'), '.')
                : null,

            default => null,
        };
    }

    public function getLiveUrlAttribute(): ?string
    {
        $host = $this->display_host;

        return $host ? 'https://'.$host : null;
    }

    /** First label of the hostname, shown in full contrast. */
    public function getHostLabelAttribute(): ?string
    {
        return $this->display_host ? Str::before($this->display_host, '.') : null;
    }

    /** Everything after the first label, shown muted. */
    public function getHostRestAttribute(): ?string
    {
        $host = $this->display_host;

        return $host && str_contains($host, '.')
            ? '.'.Str::after($host, '.')
            : null;
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function scopeOnBoard(Builder $query): Builder
    {
        return $query->where('on_board', true);
    }

    public function scopeSpotlight(Builder $query): Builder
    {
        return $query->where('is_spotlight', true);
    }
}
