<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public const TYPE_CV          = 'cv';
    public const TYPE_CERTIFICATE = 'certificate';

    public const DISK = 'documents';

    public static function types(): array
    {
        return [
            self::TYPE_CV          => 'CV',
            self::TYPE_CERTIFICATE => 'Certificate',
        ];
    }

    /** Public URL of the uploaded file, or null if none is attached. */
    public function getUrlAttribute(): ?string
    {
        return $this->file ? Storage::disk(self::DISK)->url($this->file) : null;
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderByDesc('id');
    }

    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    /** The CV shown in the contact card and the track record. */
    public static function cv(): ?self
    {
        return static::query()->published()->ofType(self::TYPE_CV)->ordered()->first();
    }

    public static function certificates()
    {
        return static::query()->published()->ofType(self::TYPE_CERTIFICATE)->ordered()->get();
    }
}
