@props([
    'category',
    'kind',
    'name',
    'summary',
    'stack',
    'status'  => 'live',
    'host'    => null,
    'repo'    => null,
    'feature' => false,
])

@php
    $live      = $host ? 'https://' . $host . '.' . config('portfolio.domain') : null;
    $isPending = in_array($status, ['beta', 'wip'], true);
@endphp

<article data-category="{{ $category }}"
         {{ $attributes->class([
             'card project-card group flex flex-col rounded-[11px] p-6',
             'cat-' . $category,
             // Feature cards break the even grid by spanning two columns.
             'sm:col-span-2' => $feature,
         ]) }}>

    <span class="card-rule rounded-tl-[11px]" aria-hidden="true"></span>

    <div class="flex items-center justify-between gap-2">
        <span class="accent-text font-mono text-[10px] uppercase tracking-[0.16em]">{{ $kind }}</span>

        @if ($isPending)
            <span class="rounded-[4px] border border-clay/60 bg-clay/10 px-2 py-0.5 font-mono text-[10px] uppercase tracking-[0.13em] text-clay">
                {{ $status === 'beta' ? 'Beta · WIP' : 'In progress' }}
            </span>
        @else
            <x-status-pill :status="$status" />
        @endif
    </div>

    <h3 @class([
        'mt-5 font-display font-bold tracking-[-0.025em] text-paper',
        'text-[1.55rem] leading-[1.1]' => $feature,
        't-card' => ! $feature,
    ])>{{ $name }}</h3>

    <p @class([
        'mt-3 flex-1 text-mute',
        'text-[15px] leading-[1.62] max-w-2xl' => $feature,
        'text-[14.5px] leading-[1.62]' => ! $feature,
    ])>{{ $summary }}</p>

    <p class="mt-5 font-mono text-[11px] text-mute/70">{{ $stack }}</p>

    <div class="mt-5 flex items-center gap-2 border-t border-line pt-5">
        {{-- Live demo is the primary action: it points at the project's own subdomain. --}}
        @if ($live && $isPending)
            <a href="{{ $live }}"
               class="flex-1 rounded-[6px] border border-clay/40 bg-clay/10 px-3 py-2.5 text-center font-mono text-[11px] uppercase tracking-[0.13em] text-clay transition-colors hover:bg-clay hover:text-ink">
                Preview beta
            </a>
        @elseif ($live)
            <a href="{{ $live }}"
               class="accent-text accent-bd flex-1 rounded-[6px] border bg-[color-mix(in_oklab,var(--accent)_14%,transparent)] px-3 py-2.5 text-center font-mono text-[11px] uppercase tracking-[0.13em] transition-colors hover:bg-[var(--accent)] hover:text-ink">
                Live demo
            </a>
        @endif

        @if ($repo)
            <a href="{{ $repo }}"
               @class([
                   'rounded-[6px] border border-line px-3 py-2.5 font-mono text-[11px] uppercase tracking-[0.13em] text-mute transition-colors hover:border-linehi hover:text-paper',
                   'flex-1 text-center' => ! $live,
               ])>
                {{ $live ? 'Code' : 'Read the code' }}
            </a>
        @elseif ($live && $isPending)
            <span class="rounded-[6px] border border-line px-3 py-2.5 font-mono text-[11px] uppercase tracking-[0.13em] text-mute/50">Soon</span>
        @elseif (! $live)
            <span class="flex-1 rounded-[6px] border border-line px-3 py-2.5 text-center font-mono text-[11px] uppercase tracking-[0.13em] text-mute/50">Private</span>
        @endif
    </div>
</article>
