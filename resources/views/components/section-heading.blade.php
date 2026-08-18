@props(['eyebrow', 'title', 'lead' => null, 'accent' => 'brass'])

{{-- No default max-width: the caller owns the measure, so two max-w-*
     utilities can never land on the same element and race each other. --}}
<div {{ $attributes }}>
    <p class="t-eyebrow flex items-center gap-3 text-[color:var(--color-{{ $accent }})]">
        <span class="h-px w-8 bg-[color:var(--color-{{ $accent }})]" aria-hidden="true"></span>
        {{ $eyebrow }}
    </p>

    <h2 class="t-section mt-5 text-paper">{{ $title }}</h2>

    @if ($lead)
        <p class="mt-5 text-[1.0625rem] leading-[1.62] text-mute">{{ $lead }}</p>
    @endif
</div>
