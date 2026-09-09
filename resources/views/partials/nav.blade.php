<header class="sticky top-0 z-50 border-b border-line/90 bg-ink/85 backdrop-blur-md">
    <div class="mx-auto flex h-14 max-w-6xl items-center justify-between px-5 sm:px-8">

        <a href="#top" class="group flex items-center gap-2.5">
            <span class="grid h-7 w-7 place-items-center rounded-[5px] border border-line bg-surface font-display text-[13px] font-extrabold text-brass">
                {{ Str::substr($profile->name, 0, 1) }}
            </span>
            <span class="font-mono text-[11px] uppercase tracking-[0.19em] text-mute transition-colors group-hover:text-paper">
                {{ $profile->short_name ?: $profile->name }}
            </span>
        </a>

        <nav aria-label="Sections" class="hidden items-center gap-8 md:flex">
            @foreach (['spotlight' => 'Spotlight', 'work' => 'Work', 'practice' => 'Practice', 'track-record' => 'Track record', 'contact' => 'Contact'] as $anchor => $label)
                <a href="#{{ $anchor }}"
                   class="font-mono text-[11px] uppercase tracking-[0.16em] text-mute transition-colors hover:text-paper">{{ $label }}</a>
            @endforeach
        </nav>

        <div class="flex items-center gap-2">
            {{-- Icon shows the theme you would switch *to*, which is the
                 convention people already read from other sites. --}}
            <button type="button"
                    data-theme-toggle
                    aria-pressed="false"
                    aria-label="Switch to light theme"
                    title="Switch theme"
                    class="tap-target relative grid h-8 w-8 place-items-center rounded-[5px] border border-line bg-surface text-mute transition-colors hover:border-linehi hover:text-paper">
                <svg class="icon-moon h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/>
                </svg>
                <svg class="icon-sun h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="4"/>
                    <path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/>
                </svg>
            </button>

            <a href="#contact"
               class="rounded-[5px] border border-brass/45 bg-brass/10 px-3.5 py-1.5 font-mono text-[11px] uppercase tracking-[0.14em] text-brass transition-colors hover:bg-brass hover:text-ink">
                Start a project
            </a>
        </div>
    </div>
</header>
