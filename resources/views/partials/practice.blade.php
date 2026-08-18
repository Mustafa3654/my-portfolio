{{-- Full-bleed band: a deliberate break in the page's rhythm so the reader
     hits a different surface between the work grid and the track record. --}}
<section id="practice" class="ambient relative overflow-hidden border-b border-line bg-ink2">
    <div class="relative z-10 mx-auto max-w-6xl px-5 py-24 sm:px-8 sm:py-32">

        <x-section-heading
            class="reveal max-w-2xl"
            eyebrow="Practice"
            accent="violet"
            title="What building here actually requires."
            lead="Not a wall of logos. These are the constraints that decide whether a system survives contact with a real business."
        />

        <div class="reveal mt-14 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @foreach (config('portfolio.practice') as $i => $item)
                {{-- Alternating hues keep six similar cards from flattening out;
                     the first card runs wide to break the even grid. --}}
                <div @class([
                    'card relative rounded-[11px] p-7',
                    ['cat-tools', 'cat-apps', 'cat-commerce'][$i % 3],
                    'md:col-span-2 lg:col-span-1' => $i === 0,
                ])>
                    <span class="card-rule rounded-tl-[11px]" aria-hidden="true"></span>

                    <p class="accent-text font-mono text-[10px] uppercase tracking-[0.18em]">{{ $item['label'] }}</p>

                    <h3 class="mt-4 font-display text-[1.25rem] font-bold leading-tight tracking-[-0.02em] text-paper">
                        {{ $item['title'] }}
                    </h3>

                    <p class="mt-3 text-[14.5px] leading-[1.68] text-mute">{{ $item['body'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
