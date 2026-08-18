@props(['title', 'note' => null, 'steps' => []])

{{--
    A hairline diagram of how the system actually moves work through itself.
    It earns its place by showing the mechanism the problem/solution copy
    describes, rather than standing in for a screenshot.
--}}
<div {{ $attributes->class(['rounded-[8px] border border-line bg-ink/50 p-5']) }}>
    <p class="font-mono text-[10px] uppercase tracking-[0.2em] text-mute/70">{{ $title }}</p>

    <div class="mt-5">
        @foreach ($steps as $i => $step)
            @if ($i > 0)
                <div class="ml-4 h-5 w-px bg-line" aria-hidden="true"></div>
            @endif

            @if (! empty($step['split']))
                <div class="grid grid-cols-2 gap-2">
                    @foreach ((array) $step['label'] as $label)
                        <div class="rounded-[5px] border border-line bg-surface px-3 py-2.5 font-mono text-[11.5px] text-paper">
                            {{ $label }}
                        </div>
                    @endforeach
                </div>
            @else
                <div @class([
                    'rounded-[5px] px-3 py-2.5 font-mono text-[11.5px]',
                    'border border-brass/60 bg-brass/[0.07] text-brass' => ! empty($step['accent']),
                    'border border-line bg-surface text-paper' => empty($step['accent']),
                ])>
                    {{ is_array($step['label']) ? implode(' / ', $step['label']) : $step['label'] }}
                </div>
            @endif
        @endforeach
    </div>

    @if ($note)
        <p class="mt-5 border-t border-line pt-4 text-[13px] leading-relaxed text-mute">{{ $note }}</p>
    @endif
</div>
