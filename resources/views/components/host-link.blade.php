@props(['host', 'size' => 'sm'])

@php
    // The hostname is this design's identifier — it replaces the 01/02/03
    // numbering you'd normally see, and it carries real information.
    //
    // Splitting at the first dot works for both shapes the site supports:
    //   wassili.mustafa.dev  ->  "wassili" + ".mustafa.dev"
    //   wassili.com          ->  "wassili" + ".com"
    $label = Str::before($host, '.');
    $rest  = Str::contains($host, '.') ? '.'.Str::after($host, '.') : '';
    $sizes = ['sm' => 'text-[13px]', 'md' => 'text-[12px]'];
@endphp

<span {{ $attributes->class(['font-mono tracking-tight', $sizes[$size] ?? $sizes['sm']]) }}>
    {{ $label }}<span class="text-mute">{{ $rest }}</span>
</span>
