@php
    $me    = config('portfolio.identity');
    $creds = config('portfolio.credentials');
@endphp

<section id="track-record" class="border-b border-line">
    <div class="mx-auto max-w-6xl px-5 py-20 sm:px-8 sm:py-24">

        <x-section-heading
            class="reveal max-w-2xl"
            eyebrow="Track record"
            title="Where the constraints were learned."
            lead="Systems and infrastructure work alongside the web projects — POS terminals, Linux servers and the support queue that tells you what actually breaks."
        />

        <div class="reveal mt-12 grid gap-10 lg:grid-cols-[1.35fr_0.65fr] lg:gap-14">

            {{-- ── Experience: dates are the structural device, because time
                    genuinely is a sequence here ── --}}
            <div>
                <p class="font-mono text-[10px] uppercase tracking-[0.2em] text-mute/70">Experience</p>

                <ol class="mt-6 space-y-8">
                    @foreach ($creds['experience'] as $role)
                        <li class="border-l border-line pl-5 sm:pl-6">
                            <p class="font-mono text-[11px] uppercase tracking-[0.14em] text-brass">
                                {{ $role['from'] }} — {{ $role['to'] }}
                            </p>

                            <h3 class="mt-2 font-display text-[1.3rem] font-bold tracking-[-0.015em] text-paper">
                                {{ $role['role'] }}
                            </h3>

                            <p class="mt-1 text-[14px] text-mute">
                                {{ $role['org'] }} · {{ $role['place'] }}
                            </p>

                            <ul class="mt-4 space-y-2.5">
                                @foreach ($role['points'] as $point)
                                    <li class="flex gap-2.5 text-[14px] leading-[1.65] text-mute">
                                        <span class="mt-[8px] h-1 w-1 shrink-0 rounded-full bg-brass" aria-hidden="true"></span>{{ $point }}
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ol>
            </div>

            {{-- ── Education, certification, languages ── --}}
            <div class="space-y-5">

                <div class="rounded-[9px] border border-line bg-surface">
                    <div class="border-b border-line px-4 py-2.5">
                        <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-mute">Education</span>
                    </div>
                    @foreach ($creds['education'] as $item)
                        <div class="px-4 py-4">
                            <p class="font-mono text-[11px] tracking-[0.1em] text-brass">{{ $item['from'] }}–{{ $item['to'] }}</p>
                            <p class="mt-1.5 font-display text-[1.05rem] font-bold text-paper">{{ $item['award'] }}</p>
                            <p class="mt-0.5 text-[13px] text-mute">{{ $item['org'] }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="rounded-[9px] border border-line bg-surface">
                    <div class="border-b border-line px-4 py-2.5">
                        <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-mute">Certification</span>
                    </div>
                    @foreach ($creds['certifications'] as $cert)
                        <div class="px-4 py-4">
                            <p class="font-mono text-[11px] tracking-[0.1em] text-brass">{{ $cert['date'] }}</p>
                            <p class="mt-1.5 font-display text-[1.05rem] font-bold text-paper">{{ $cert['award'] }}</p>
                            <p class="mt-0.5 text-[13px] leading-relaxed text-mute">{{ $cert['org'] }}</p>

                            {{-- The ID is printed on the certificate, so it stays verifiable. --}}
                            <p class="mt-2 font-mono text-[10px] tracking-[0.08em] text-mute/70">{{ $cert['id'] }}</p>

                            @if (! empty($cert['file']))
                                <a href="{{ $cert['file'] }}" target="_blank" rel="noopener"
                                   class="mt-3 inline-block rounded-[5px] border border-line px-3 py-1.5 font-mono text-[10px] uppercase tracking-[0.13em] text-mute transition-colors hover:border-linehi hover:text-paper">
                                    View certificate
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="rounded-[9px] border border-line bg-surface">
                    <div class="border-b border-line px-4 py-2.5">
                        <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-mute">Languages</span>
                    </div>
                    <dl class="divide-y divide-line">
                        @foreach ($creds['languages'] as $lang)
                            <div class="flex items-center justify-between gap-4 px-4 py-3">
                                <dt class="text-[13px] text-paper">{{ $lang['name'] }}</dt>
                                <dd class="font-mono text-[11px] uppercase tracking-[0.13em] text-mute">{{ $lang['level'] }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>

                @if ($me['cv'])
                    <a href="{{ $me['cv'] }}" target="_blank" rel="noopener"
                       class="flex items-center justify-between gap-4 rounded-[9px] border border-brass/45 bg-brass/10 px-4 py-3.5 transition-colors hover:bg-brass hover:text-ink">
                        <span class="font-mono text-[11px] uppercase tracking-[0.14em] text-brass transition-colors group-hover:text-ink">Download CV</span>
                        <span class="font-mono text-[11px] text-brass/70">PDF</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
