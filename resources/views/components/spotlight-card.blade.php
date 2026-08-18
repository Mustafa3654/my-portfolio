@props([
    'name',
    'host',
    'tagline',
    'problem',
    'solution',
    'points'      => [],
    'stack'       => [],
    'repo'        => null,
    'flow'        => null,
    'mediaFirst'  => false,
])

@php $live = 'https://' . $host . '.' . config('portfolio.domain'); @endphp

<article {{ $attributes->class([
    'ticked reveal relative overflow-hidden rounded-[14px] border border-line bg-surface transition-colors hover:border-linehi',
]) }}>

    {{-- Ticket header: the hostname identifies the system, the live button is the point --}}
    <header class="flex flex-wrap items-center justify-between gap-3 border-b border-line bg-raise/50 px-5 py-3">
        <x-host-link :host="$host" size="md" class="text-paper" />

        <div class="flex items-center gap-2">
            <a href="{{ $live }}"
               class="flex items-center gap-2 rounded-[5px] bg-brass px-3.5 py-1.5 font-mono text-[11px] uppercase tracking-[0.13em] text-ink transition-colors hover:bg-brass/85">
                <span class="h-1.5 w-1.5 rounded-full bg-ink" aria-hidden="true"></span>Live demo
            </a>

            @if ($repo)
                <a href="{{ $repo }}"
                   class="rounded-[5px] border border-line px-3.5 py-1.5 font-mono text-[11px] uppercase tracking-[0.13em] text-mute transition-colors hover:border-linehi hover:text-paper">
                    Source
                </a>
            @endif
        </div>
    </header>

    <div @class([
        'grid gap-10 p-5 sm:p-8 lg:gap-12',
        'lg:grid-cols-[0.85fr_1.15fr]' => $mediaFirst,
        'lg:grid-cols-[1.15fr_0.85fr]' => ! $mediaFirst,
    ])>

        @if ($flow)
            <x-flow-diagram
                :title="$flow['title']"
                :note="$flow['note'] ?? null"
                :steps="$flow['steps']"
                :class="$mediaFirst ? 'order-2 lg:order-1' : 'order-2'"
            />
        @endif

        <div @class(['order-1 lg:order-2' => $mediaFirst, 'order-1' => ! $mediaFirst])>
            <h3 class="font-display text-[clamp(1.55rem,2.3vw,2.05rem)] font-extrabold leading-[1.04] tracking-[-0.028em] text-paper">{{ $name }}</h3>
            <p class="mt-2 text-[15px] text-mute">{{ $tagline }}</p>

            <div class="mt-7 space-y-6">
                <div class="border-l-2 border-clay/70 pl-4">
                    <p class="font-mono text-[10px] uppercase tracking-[0.2em] text-clay">Problem</p>
                    <p class="mt-2 text-[15px] leading-[1.7] text-mute">{{ $problem }}</p>
                </div>

                <div class="border-l-2 border-brass pl-4">
                    <p class="font-mono text-[10px] uppercase tracking-[0.2em] text-brass">Solution</p>
                    <p class="mt-2 text-[15px] leading-[1.7] text-mute">{{ $solution }}</p>
                </div>
            </div>

            @if ($points)
                <ul class="mt-7 grid gap-2.5 sm:grid-cols-2">
                    @foreach ($points as $point)
                        <li class="flex gap-2.5 text-[14px] leading-snug text-mute">
                            <span class="mt-[7px] h-1 w-1 shrink-0 rounded-full bg-brass" aria-hidden="true"></span>{{ $point }}
                        </li>
                    @endforeach
                </ul>
            @endif

            @if ($stack)
                <div class="mt-7 flex flex-wrap gap-1.5">
                    @foreach ($stack as $tech)
                        <span class="rounded-[4px] border border-line bg-raise px-2.5 py-1 font-mono text-[10.5px] tracking-[0.05em] text-mute">{{ $tech }}</span>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</article>
