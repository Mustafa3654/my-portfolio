@php
    $me      = config('portfolio.identity');
    $contact = config('portfolio.contact');
@endphp

<section id="contact">
    <div class="mx-auto max-w-6xl px-5 py-20 sm:px-8 sm:py-28">
        <div class="reveal grid gap-12 lg:grid-cols-[1fr_auto] lg:items-end">

            <div class="max-w-2xl">
                <p class="font-mono text-[11px] uppercase tracking-[0.2em] text-brass">Contact</p>

                <h2 class="mt-4 font-display text-[2.2rem] font-extrabold leading-[1.02] tracking-[-0.03em] text-paper sm:text-[3.1rem]">
                    {{ $contact['heading'][0] }}<br class="hidden sm:block"> {{ $contact['heading'][1] }}
                </h2>

                <p class="mt-5 text-[1.0625rem] leading-[1.65] text-mute">{{ $contact['body'] }}</p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="mailto:{{ $me['email'] }}"
                       class="rounded-[6px] bg-brass px-5 py-2.5 text-sm font-semibold text-ink transition-colors hover:bg-brass/85">
                        {{ $me['email'] }}
                    </a>
                    <a href="tel:{{ $me['phone_tel'] }}"
                       class="rounded-[6px] border border-line bg-surface px-5 py-2.5 text-sm font-semibold text-paper transition-colors hover:border-linehi hover:bg-raise">
                        {{ $me['phone'] }}
                    </a>
                </div>
            </div>

            <div class="w-full max-w-xs rounded-[9px] border border-line bg-surface">
                <div class="border-b border-line px-4 py-2.5">
                    <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-mute">Details</span>
                </div>

                <dl class="divide-y divide-line">
                    @foreach ($contact['details'] as $detail)
                        <div class="flex items-center justify-between gap-4 px-4 py-3">
                            <dt class="font-mono text-[11px] uppercase tracking-[0.13em] text-mute">{{ $detail['label'] }}</dt>
                            <dd class="text-[13px] text-paper">{{ $detail['value'] }}</dd>
                        </div>
                    @endforeach

                    @if ($me['cv'])
                        <div class="flex items-center justify-between gap-4 px-4 py-3">
                            <dt class="font-mono text-[11px] uppercase tracking-[0.13em] text-mute">CV</dt>
                            <dd><a href="{{ $me['cv'] }}" class="text-[13px] text-brass hover:underline">Download PDF</a></dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</section>
