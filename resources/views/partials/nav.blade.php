@php $me = config('portfolio.identity'); @endphp

<header class="sticky top-0 z-50 border-b border-line/90 bg-ink/85 backdrop-blur-md">
    <div class="mx-auto flex h-14 max-w-6xl items-center justify-between px-5 sm:px-8">

        <a href="#top" class="group flex items-center gap-2.5">
            <span class="grid h-7 w-7 place-items-center rounded-[5px] border border-line bg-surface font-display text-[13px] font-extrabold text-brass">
                {{ Str::substr($me['name'], 0, 1) }}
            </span>
            <span class="font-mono text-[11px] uppercase tracking-[0.19em] text-mute transition-colors group-hover:text-paper">
                {{ $me['short'] }}
            </span>
        </a>

        <nav aria-label="Sections" class="hidden items-center gap-8 md:flex">
            @foreach (['spotlight' => 'Spotlight', 'work' => 'Work', 'practice' => 'Practice', 'track-record' => 'Track record', 'contact' => 'Contact'] as $anchor => $label)
                <a href="#{{ $anchor }}"
                   class="font-mono text-[11px] uppercase tracking-[0.16em] text-mute transition-colors hover:text-paper">{{ $label }}</a>
            @endforeach
        </nav>

        <a href="#contact"
           class="rounded-[5px] border border-brass/45 bg-brass/10 px-3.5 py-1.5 font-mono text-[11px] uppercase tracking-[0.14em] text-brass transition-colors hover:bg-brass hover:text-ink">
            Start a project
        </a>
    </div>
</header>
