@php
    $me    = config('portfolio.identity');
    $hero  = config('portfolio.hero');
    // $board comes from HomeController (Project::onBoard()).
    $liveCount = $board->whereIn('status', ['live', 'in-use'])->count();
    $betaCount = $board->whereIn('status', ['beta', 'wip'])->count();
@endphp

<section class="relative overflow-hidden border-b border-line">
    <div class="drafting pointer-events-none absolute inset-0" aria-hidden="true"></div>

    <div class="relative mx-auto grid max-w-6xl gap-14 px-5 pt-16 pb-20 sm:px-8 sm:pt-24 sm:pb-28 lg:grid-cols-[1.04fr_0.96fr] lg:gap-16">

        {{-- ── Statement ── --}}
        <div class="reveal">
            <p class="flex flex-wrap items-center gap-x-3 gap-y-2 font-mono text-[11px] uppercase tracking-[0.2em] text-mute">
                @if ($me['available'])
                    <span class="beacon inline-block h-1.5 w-1.5 rounded-full bg-signal text-signal" aria-hidden="true"></span>
                @endif
                <span>{{ $me['location'] }}</span>
                <span class="text-line" aria-hidden="true">/</span>
                <span>{{ $me['available'] ? 'Open to work & contracts' : 'Currently booked' }}</span>
            </p>

            <h1 class="mt-7 font-display text-[2.7rem] font-extrabold leading-[0.94] tracking-[-0.032em] text-paper sm:text-[3.6rem] lg:text-[4.15rem]">
                @foreach ($hero['headline'] as $i => $line)
                    <span @class(['text-brass' => $i === $hero['accent_line']])>{{ $line }}</span>@if (! $loop->last)<br>@endif
                @endforeach
            </h1>

            <p class="mt-7 max-w-xl text-[1.0625rem] leading-[1.68] text-mute">{{ $hero['bio'] }}</p>

            <div class="mt-9 flex flex-wrap items-center gap-3">
                <a href="#spotlight"
                   class="rounded-[6px] bg-brass px-5 py-2.5 text-sm font-semibold text-ink transition-colors hover:bg-brass/85">
                    See how they work
                </a>
                <a href="#contact"
                   class="rounded-[6px] border border-line bg-surface px-5 py-2.5 text-sm font-semibold text-paper transition-colors hover:border-linehi hover:bg-raise">
                    Get in touch
                </a>
            </div>

            <dl class="mt-11 grid max-w-lg grid-cols-3 gap-px overflow-hidden rounded-[6px] border border-line bg-line">
                @foreach ($hero['stats'] as $stat)
                    <div class="bg-surface px-4 py-3.5">
                        <dt class="font-mono text-[10px] uppercase tracking-[0.16em] text-mute">{{ $stat['label'] }}</dt>
                        <dd class="mt-1 font-display text-xl font-bold text-paper">{{ $stat['value'] }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>

        {{-- ── Signature element: the deployment board ── --}}
        <div class="reveal lg:pt-3">
            <div class="overflow-hidden rounded-[8px] border border-line bg-surface shadow-[0_18px_50px_-24px_rgba(0,0,0,.85)]">

                <div class="flex items-center justify-between border-b border-line bg-raise/60 px-4 py-2.5">
                    <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-mute">Deployment board</span>
                    <span class="flex items-center gap-2 font-mono text-[10px] uppercase tracking-[0.14em] text-signal">
                        <span class="h-1.5 w-1.5 rounded-full bg-signal" aria-hidden="true"></span>
                        {{ $liveCount }} live @if ($betaCount) / {{ $betaCount }} beta @endif
                    </span>
                </div>

                <div class="grid grid-cols-[minmax(0,1fr)_auto] border-b border-line px-4 py-2 font-mono text-[10px] uppercase tracking-[0.16em] text-mute/70">
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

            <p class="mt-3 px-1 font-mono text-[10px] leading-relaxed tracking-[0.1em] text-mute/70">
                Every project runs on its own subdomain. Click a host to open it.
            </p>
        </div>
    </div>
</section>
