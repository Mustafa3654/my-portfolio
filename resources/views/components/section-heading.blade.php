@props(['eyebrow', 'title', 'lead' => null])

{{-- No default max-width: the caller owns the measure, so two max-w-* utilities
     can never land on the same element and race each other. --}}
<div {{ $attributes }}>
    <p class="font-mono text-[11px] uppercase tracking-[0.2em] text-brass">{{ $eyebrow }}</p>

    <h2 class="mt-4 font-display text-[2rem] font-bold leading-[1.05] tracking-[-0.025em] text-paper sm:text-[2.6rem]">
        {{ $title }}
    </h2>

    @if ($lead)
        <p class="mt-4 text-[1.0625rem] leading-[1.65] text-mute">{{ $lead }}</p>
    @endif
</div>
