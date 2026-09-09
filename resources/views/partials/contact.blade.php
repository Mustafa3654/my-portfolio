@php $details = config('portfolio.contact.details', []); @endphp

<section id="contact">
    <div class="mx-auto max-w-6xl px-5 py-24 sm:px-8 sm:py-36">
        <div class="reveal grid gap-12 lg:grid-cols-[1fr_auto] lg:items-end">

            <div class="max-w-2xl">
                <p class="font-mono text-[11px] uppercase tracking-[0.2em] text-brass">Contact</p>

                <h2 class="t-section mt-5 text-paper">
                    {{ $profile->contact_heading }}
                </h2>

                <p class="mt-5 text-[1.0625rem] leading-[1.65] text-mute">{{ $profile->contact_body }}</p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="mailto:{{ $profile->email }}"
                       class="rounded-[6px] bg-brass px-5 py-2.5 text-sm font-semibold text-ink transition-colors hover:bg-brass/85">
                        {{ $profile->email }}
                    </a>
                    <a href="tel:{{ $profile->phone_tel }}"
                       class="rounded-[6px] border border-line bg-surface px-5 py-2.5 text-sm font-semibold text-paper transition-colors hover:border-linehi hover:bg-raise">
                        {{ $profile->phone }}
                    </a>
                </div>
            </div>

            <div class="w-full max-w-xs rounded-[9px] border border-line bg-surface">
                <div class="border-b border-line px-4 py-2.5">
                    <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-mute">Details</span>
                </div>

                <dl class="divide-y divide-line">
                    @foreach ($details as $detail)
                        <div class="flex items-center justify-between gap-4 px-4 py-3">
                            <dt class="font-mono text-[11px] uppercase tracking-[0.13em] text-mute">{{ $detail['label'] }}</dt>
                            <dd class="text-[13px] text-paper">{{ $detail['value'] }}</dd>
                        </div>
                    @endforeach

                    @if ($cv?->url)
                        <div class="flex items-center justify-between gap-4 px-4 py-3">
                            <dt class="font-mono text-[11px] uppercase tracking-[0.13em] text-mute">CV</dt>
                            <dd><a href="{{ $cv->url }}" target="_blank" rel="noopener" class="text-[13px] text-brass hover:underline">Download PDF</a></dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</section>
