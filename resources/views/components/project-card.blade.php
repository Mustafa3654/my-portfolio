@props([
    'category',
    'kind',
    'name',
    'summary',
    'stack',
    'status' => 'live',
    'host'   => null,
    'repo'   => null,
])

@php
    $live      = $host ? 'https://' . $host . '.' . config('portfolio.domain') : null;
    $isPending = in_array($status, ['beta', 'wip'], true);
@endphp

<article data-category="{{ $category }}"
         {{ $attributes->class([
             'project-card group flex flex-col rounded-[9px] border border-line bg-surface p-5',
             'transition-all duration-300 hover:-translate-y-0.5 hover:border-linehi hover:bg-raise/40',
         ]) }}>

    <div class="flex items-center justify-between gap-2">
        <span class="font-mono text-[10px] uppercase tracking-[0.16em] text-mute/70">{{ $kind }}</span>

        @if ($isPending)
            <span class="rounded-[4px] border border-clay/60 bg-clay/10 px-2 py-0.5 font-mono text-[10px] uppercase tracking-[0.13em] text-clay">
                {{ $status === 'beta' ? 'Beta · WIP' : 'In progress' }}
            </span>
        @else
            <x-status-pill :status="$status" />
        @endif
    </div>

    <h3 class="mt-4 font-display text-[1.3rem] font-bold tracking-[-0.015em] text-paper">{{ $name }}</h3>

    <p class="mt-2 flex-1 text-[14px] leading-[1.65] text-mute">{{ $summary }}</p>

    <p class="mt-4 font-mono text-[11px] text-mute/80">{{ $stack }}</p>

    <div class="mt-4 flex items-center gap-2 border-t border-line pt-4">
        {{-- Live demo is the primary action: it points at the project's own subdomain. --}}
        @if ($live && $isPending)
            <a href="{{ $live }}"
               class="flex-1 rounded-[5px] border border-clay/40 bg-clay/10 px-3 py-2 text-center font-mono text-[11px] uppercase tracking-[0.13em] text-clay transition-colors hover:bg-clay hover:text-ink">
                Preview beta
            </a>
        @elseif ($live)
            <a href="{{ $live }}"
               class="flex-1 rounded-[5px] bg-brass/12 px-3 py-2 text-center font-mono text-[11px] uppercase tracking-[0.13em] text-brass transition-colors hover:bg-brass hover:text-ink">
                Live demo
            </a>
        @endif

        @if ($repo)
            <a href="{{ $repo }}"
               @class([
                   'rounded-[5px] border border-line px-3 py-2 font-mono text-[11px] uppercase tracking-[0.13em] text-mute transition-colors hover:border-linehi hover:text-paper',
                   'flex-1 text-center' => ! $live,
               ])>
                {{ $live ? 'Code' : 'Read the code' }}
            </a>
        @elseif ($live && $isPending)
            <span class="rounded-[5px] border border-line px-3 py-2 font-mono text-[11px] uppercase tracking-[0.13em] text-mute/50">Soon</span>
        @elseif (! $live)
            <span class="flex-1 rounded-[5px] border border-line px-3 py-2 text-center font-mono text-[11px] uppercase tracking-[0.13em] text-mute/50">Private</span>
        @endif
    </div>
</article>
