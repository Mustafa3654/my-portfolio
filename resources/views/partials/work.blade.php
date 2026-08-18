@php
    $projects   = collect(config('portfolio.projects'));
    $categories = config('portfolio.categories');

    // Counts come from the data, so a new project in config updates the chips too.
    $counts = collect($categories)->map(fn ($label, $key) =>
        $key === 'all' ? $projects->count() : $projects->where('category', $key)->count()
    );
@endphp

<section id="work" class="border-b border-line">
    <div class="mx-auto max-w-6xl px-5 py-20 sm:px-8 sm:py-24">

        <div class="reveal flex flex-col gap-7 border-b border-line pb-7 md:flex-row md:items-end md:justify-between">
            <x-section-heading
                class="max-w-xl"
                eyebrow="All work"
                title="Everything else that's running."
            />

            <div role="group" aria-label="Filter projects by type" class="flex flex-wrap gap-1.5">
                @foreach ($categories as $key => $label)
                    <button type="button"
                            data-filter="{{ $key }}"
                            aria-pressed="{{ $key === 'all' ? 'true' : 'false' }}"
                            class="rounded-[5px] border border-line bg-surface px-3.5 py-2 font-mono text-[11px] uppercase tracking-[0.13em] text-mute transition-colors hover:border-linehi hover:text-paper aria-pressed:border-brass aria-pressed:bg-brass aria-pressed:text-ink">
                        {{ $label }} <span class="opacity-60">{{ $counts[$key] }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($projects as $project)
                <x-project-card
                    :category="$project['category']"
                    :kind="$project['kind']"
                    :name="$project['name']"
                    :summary="$project['summary']"
                    :stack="$project['stack']"
                    :status="$project['status']"
                    :host="$project['host']"
                    :repo="$project['repo']"
                />
            @endforeach
        </div>

        <p data-empty-state class="mt-10 hidden text-center font-mono text-[12px] text-mute">
            Nothing in this category yet. Pick another filter.
        </p>
    </div>
</section>
