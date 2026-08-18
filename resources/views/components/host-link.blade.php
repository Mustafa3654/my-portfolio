@props(['host', 'domain' => null, 'size' => 'sm'])

@php
    // The hostname is this design's identifier — it replaces the 01/02/03
    // numbering you'd normally see, and it carries real information.
    $domain = $domain ?? config('portfolio.domain');
    $sizes  = ['sm' => 'text-[13px]', 'md' => 'text-[12px]'];
@endphp

<span {{ $attributes->class(['font-mono tracking-tight', $sizes[$size] ?? $sizes['sm']]) }}>
    {{ $host }}<span class="text-mute">.{{ $domain }}</span>
</span>
