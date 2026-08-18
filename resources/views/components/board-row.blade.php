@props(['host', 'summary', 'status' => 'live', 'last' => false])

@php $url = 'https://' . $host . '.' . config('portfolio.domain'); @endphp

<li class="board-row">
    <a href="{{ $url }}"
       class="group grid grid-cols-[minmax(0,1fr)_auto] items-center gap-4 px-4 py-3.5 transition-colors hover:bg-raise @unless($last) border-b border-line @endunless">
        <span class="min-w-0">
            <span class="block truncate font-mono text-[13px] text-paper transition-colors group-hover:text-brass">
                {{ $host }}<span class="text-mute">.{{ config('portfolio.domain') }}</span>
            </span>
            <span class="mt-0.5 block truncate text-[13px] text-mute">{{ $summary }}</span>
        </span>

        <x-status-pill :status="$status" />
    </a>
</li>
