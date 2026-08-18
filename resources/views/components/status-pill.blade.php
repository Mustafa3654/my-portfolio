@props(['status' => 'live'])

@php
    // Colour is reserved, not decorative: teal means running, clay means not yet.
    $map = [
        'live'    => ['label' => 'Live',        'tone' => 'signal', 'solid' => true],
        'in-use'  => ['label' => 'In use',      'tone' => 'signal', 'solid' => true],
        'beta'    => ['label' => 'Beta',        'tone' => 'clay',   'solid' => false],
        'wip'     => ['label' => 'In progress', 'tone' => 'clay',   'solid' => false],
        'private' => ['label' => 'Private',     'tone' => 'mute',   'solid' => false],
    ];

    $meta  = $map[$status] ?? $map['live'];
    $tone  = $meta['tone'];
    $text  = ['signal' => 'text-signal', 'clay' => 'text-clay', 'mute' => 'text-mute/70'][$tone];
    $dot   = $meta['solid']
        ? ['signal' => 'bg-signal', 'clay' => 'bg-clay', 'mute' => 'bg-mute'][$tone]
        : 'border ' . ['signal' => 'border-signal', 'clay' => 'border-clay', 'mute' => 'border-mute'][$tone];
@endphp

<span {{ $attributes->class([
    'flex items-center gap-1.5 font-mono text-[10px] uppercase tracking-[0.13em]',
    $text,
]) }}>
    <span class="h-1.5 w-1.5 rounded-full {{ $dot }}"></span>{{ $meta['label'] }}
</span>
