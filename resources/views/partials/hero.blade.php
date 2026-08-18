@php
    $me   = config('portfolio.identity');
    $hero = config('portfolio.hero');
    // $board comes from HomeController (Project::onBoard()).
    $liveCount = $board->whereIn('status', ['live', 'in-use'])->count();
    $betaCount = $board->whereIn('status', ['beta', 'wip'])->count();
@endphp

<section class="ambient relative overflow-hidden border-b border-line">
    <div data-parallax="0.14" class="drafting pointer-events-none absolute inset-0 z-0" aria-hidden="true"></div>

    <div class="relative z-10 mx-auto max-w-6xl px-5 pt-14 pb-16 sm:px-8 sm:pt-20 sm:pb-24">

        {{-- ── Statement: full width so the headline can run big ── --}}
        <p class="t-eyebrow flex flex-wrap items-center gap-x-3 gap-y-2 text-mute">
            @if ($me['available'])
                <span class="beacon inline-block h-1.5 w-1.5 rounded-full bg-signal text-signal" aria-hidden="true"></span>
            @endif
            <span>{{ $me['location'] }}</span>
            <span class="text-linehi" aria-hidden="true">/</span>
            <span>{{ $me['available'] ? 'Open to work & contracts' : 'Currently booked' }}</span>
        </p>

        <h1 class="t-hero mt-8 text-paper">
            @foreach ($hero['headline'] as $i => $line)
                <span class="line-mask">
                    <span @class(['accent-text [--accent:var(--color-brass)]' => $i === $hero['accent_line']])>{{ $line }}</span>
                </span>
            @endforeach
        </h1>

        <div class="mt-10 grid gap-12 lg:grid-cols-[1.02fr_0.98fr] lg:gap-16">

            <div class="reveal">
                <p class="max-w-xl text-[1.125rem] leading-[1.62] text-mute">{{ $hero['bio'] }}</p>

                <div class="mt-9 flex flex-wrap items-center gap-3">
                    <a href="#spotlight"
                       class="group relative overflow-hidden rounded-[7px] bg-brass px-6 py-3 text-[15px] font-semibold text-ink transition-transform duration-300 hover:-translate-y-0.5">
                        See how they work
                    </a>
                    <a href="#contact"
                       class="rounded-[7px] border border-line bg-surface px-6 py-3 text-[15px] font-semibold text-paper transition-all duration-300 hover:-translate-y-0.5 hover:border-linehi hover:bg-raise">
                        Get in touch
                    </a>
                </div>

                {{-- Stats step up in scale and count in on view --}}
                <dl class="mt-12 grid max-w-xl grid-cols-3 gap-px overflow-hidden rounded-[9px] border border-line bg-line">
                    @foreach ($hero['stats'] as $stat)
                        @php
                            // Split a leading number off so it can animate,
                            // e.g. "15 systems" → 15 + " systems".
                            preg_match('/^(\d+)(.*)$/', $stat['value'], $m);
                        @endphp
                        <div class="bg-surface px-4 py-5">
                            <dt class="t-eyebrow text-mute">{{ $stat['label'] }}</dt>
                            <dd class="mt-2 font-display text-[1.6rem] font-extrabold leading-none tracking-[-0.03em] text-paper">
                                @if ($m)
                                    <span data-count="{{ $m[1] }}" data-count-suffix="{{ $m[2] }}">{{ $stat['value'] }}</span>
                                @else
                                    {{ $stat['value'] }}
                                @endif
                            </dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            {{-- ── Signature element: the deployment board ── --}}
            <div data-parallax="-0.03">
                <div class="sweep overflow-hidden rounded-[10px] border border-line bg-surface shadow-[0_28px_70px_-32px_rgba(0,0,0,.95)]">

                    <div class="flex items-center justify-between border-b border-line bg-raise/70 px-4 py-3">
                        <span class="t-eyebrow text-mute">Deployment board</span>
                        <span class="flex items-center gap-2 font-mono text-[10px] uppercase tracking-[0.14em] text-signal">
                            <span class="beacon inline-block h-1.5 w-1.5 rounded-full bg-signal text-signal" aria-hidden="true"></span>
                            {{ $liveCount }} live @if ($betaCount) / {{ $betaCount }} beta @endif
                        </span>
                    </div>

                    <div class="grid grid-cols-[minmax(0,1fr)_auto] border-b border-line px-4 py-2 font-mono text-[10px] uppercase tracking-[0.16em] text-mute/60">
                        <span>Host</span><span>Status</span>
                    </div>

                    <ul>
                        @foreach ($board as $row)
                            <x-board-row
                                :host="$row->host"
                                :summary="$row->board_summary ?? $row->summary"
                                :status="$row->status"
                                :last="$loop->last"
                            />
                        @endforeach
                    </ul>
                </div>

                <p class="mt-3 px-1 font-mono text-[10px] leading-relaxed tracking-[0.1em] text-mute/60">
                    Every project runs on its own subdomain. Click a host to open it.
                </p>
            </div>
        </div>
    </div>
</section>
