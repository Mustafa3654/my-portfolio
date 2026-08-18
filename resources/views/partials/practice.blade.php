<section id="practice" class="border-b border-line">
    <div class="mx-auto max-w-6xl px-5 py-20 sm:px-8 sm:py-24">

        <x-section-heading
            class="reveal max-w-2xl"
            eyebrow="Practice"
            title="What building here actually requires."
            lead="Not a wall of logos. These are the constraints that decide whether a system survives contact with a real business."
        />

        <div class="reveal mt-12 grid gap-px overflow-hidden rounded-[10px] border border-line bg-line md:grid-cols-2 lg:grid-cols-3">
            @foreach (config('portfolio.practice') as $item)
                <div class="bg-surface p-6">
                    <p class="font-mono text-[10px] uppercase tracking-[0.18em] text-brass">{{ $item['label'] }}</p>
                    <h3 class="mt-3 font-display text-[1.15rem] font-bold text-paper">{{ $item['title'] }}</h3>
                    <p class="mt-2.5 text-[14px] leading-[1.7] text-mute">{{ $item['body'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
