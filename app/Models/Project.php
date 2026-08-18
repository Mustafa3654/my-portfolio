<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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

    /** Full URL to the project's own subdomain, or null if it isn't deployed. */
    public function getLiveUrlAttribute(): ?string
    {
        return $this->host
            ? 'https://'.$this->host.'.'.config('portfolio.domain')
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
