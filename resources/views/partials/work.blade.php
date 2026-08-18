@php
    // $projects comes from HomeController.
    $categories = config('portfolio.categories');

    // Counts come from the data, so a new project updates the chips too.
    $counts = collect($categories)->map(fn ($label, $key) =>
        $key === 'all' ? $projects->count() : $projects->where('category', $key)->count()
    );

    // The first project of each category runs double-width, so the grid has a
    // rhythm instead of fifteen identical tiles.
    $featured = $projects->groupBy('category')->map->first()->pluck('id')->all();
@endphp

<section id="work" class="relative border-b border-line">
    <div class="mx-auto max-w-6xl px-5 py-24 sm:px-8 sm:py-32">

        <div class="flex flex-col gap-8 border-b border-line pb-8 md:flex-row md:items-end md:justify-between">
            <x-section-heading
                class="reveal max-w-xl"
                eyebrow="All work"
                title="Everything else that's running."
            />

            <div role="group" aria-label="Filter projects by type" class="flex flex-wrap gap-1.5">
                @foreach ($categories as $key => $label)
                    <button type="button"
                            data-filter="{{ $key }}"
                            aria-pressed="{{ $key === 'all' ? 'true' : 'false' }}"
                            class="rounded-[6px] border border-line bg-surface px-4 py-2.5 font-mono text-[11px] uppercase tracking-[0.13em] text-mute transition-all duration-300 hover:-translate-y-0.5 hover:border-linehi hover:text-paper aria-pressed:border-brass aria-pressed:bg-brass aria-pressed:text-ink">
                        {{ $label }} <span class="opacity-60">{{ $counts[$key] }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($projects as $project)
                <x-project-card
                    :category="$project->category"
                    :kind="$project->kind"
                    :name="$project->name"
                    :summary="$project->summary"
                    :stack="$project->stack"
                    :status="$project->status"
                    :host="$project->host"
                    :repo="$project->repo"
                    :feature="in_array($project->id, $featured, true)"
                />
            @endforeach
        </div>

        <p data-empty-state class="mt-10 hidden text-center font-mono text-[12px] text-mute">
            Nothing in this category yet. Pick another filter.
        </p>
    </div>
</section>
