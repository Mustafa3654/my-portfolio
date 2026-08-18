<section id="spotlight" class="border-b border-line">
    <div class="mx-auto max-w-6xl px-5 py-20 sm:px-8 sm:py-24">

        <x-section-heading
            class="reveal max-w-2xl"
            eyebrow="Spotlight"
            title="Two systems, and the problems that shaped them."
            lead="Both started as somebody's daily workaround — a WhatsApp thread, a folder of scanned PDFs. The engineering was in replacing the workaround without asking anyone to change how they work."
        />

        <div class="mt-14 space-y-8">
            @foreach ($spotlight as $project)
                <x-spotlight-card
                    :name="$project->name"
                    :host="$project->host"
                    :tagline="$project->tagline"
                    :problem="$project->problem"
                    :solution="$project->solution"
                    :points="$project->points ?? []"
                    :stack="$project->tech ?? []"
                    :repo="$project->repo"
                    :flow="$project->flow"
                    :media-first="$project->media_first"
                />
            @endforeach
        </div>
    </div>
</section>
