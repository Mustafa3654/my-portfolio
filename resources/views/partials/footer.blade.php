@php $me = config('portfolio.identity'); @endphp

<footer class="border-t border-line">
    <div class="mx-auto flex max-w-6xl flex-col gap-5 px-5 py-8 sm:flex-row sm:items-center sm:justify-between sm:px-8">
        <p class="font-mono text-[11px] tracking-[0.08em] text-mute">
            &copy; <span data-current-year>{{ date('Y') }}</span> {{ $me['name'] }} — built with Laravel &amp; Filament
        </p>

        <div class="flex items-center gap-6">
            <a href="{{ $me['github'] }}" class="font-mono text-[11px] uppercase tracking-[0.14em] text-mute transition-colors hover:text-paper">GitHub</a>
            <a href="{{ $me['linkedin'] }}" class="font-mono text-[11px] uppercase tracking-[0.14em] text-mute transition-colors hover:text-paper">LinkedIn</a>
            <a href="#top" class="font-mono text-[11px] uppercase tracking-[0.14em] text-mute transition-colors hover:text-paper">Back to top</a>
        </div>
    </div>
</footer>
