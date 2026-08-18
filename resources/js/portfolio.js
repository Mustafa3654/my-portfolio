/*
| Portfolio front-end behaviour
|
| Reveals, the hero load sequence, scroll-linked parallax, pointer-tracked
| cards, counters and the project filter. Everything degrades to visible,
| usable content: motion is an enhancement, never a prerequisite.
*/

const reduced = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;

function currentYear() {
    const el = document.querySelector('[data-current-year]');
    if (el) el.textContent = new Date().getFullYear();
}

/* ── Hero load sequence ────────────────────────────────────────────────
   Headline lines slide up out of their masks, then the board rows come in.
   One orchestrated moment rather than effects scattered down the page. */
function heroSequence(reduce) {
    const lines = document.querySelectorAll('.line-mask');
    const rows = document.querySelectorAll('.board-row');

    if (reduce) {
        lines.forEach((l) => l.classList.add('line-in'));
        rows.forEach((r) => r.classList.add('in'));
        return;
    }

    lines.forEach((line, i) => setTimeout(() => line.classList.add('line-in'), 90 + i * 110));
    rows.forEach((row, i) => setTimeout(() => row.classList.add('in'), 520 + i * 80));
}

/* ── Scroll reveals ───────────────────────────────────────────────────*/
function scrollReveals(reduce) {
    const reveals = document.querySelectorAll('.reveal');
    if (!reveals.length) return;

    // Children stagger off an index the CSS reads as an animation delay.
    reveals.forEach((el) => {
        [...el.children].forEach((child, i) => {
            child.style.animationDelay = `${Math.min(i * 70, 560)}ms`;
        });
    });

    if (reduce || !('IntersectionObserver' in window)) {
        reveals.forEach((el) => el.classList.add('in'));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('in');
            observer.unobserve(entry.target);
        });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.05 });

    reveals.forEach((el) => observer.observe(el));

    // Content must never stay stuck at opacity 0.
    setTimeout(() => {
        reveals.forEach((el) => {
            if (el.getBoundingClientRect().top < window.innerHeight) el.classList.add('in');
        });
    }, 1400);
}

/* ── Scroll-linked parallax ───────────────────────────────────────────
   Driven from a single rAF-throttled scroll listener so we never stack
   layout reads per element. */
function parallax(reduce) {
    const layers = document.querySelectorAll('[data-parallax]');
    if (reduce || !layers.length) return;

    let ticking = false;

    const apply = () => {
        const y = window.scrollY;
        layers.forEach((el) => {
            const speed = parseFloat(el.dataset.parallax) || 0.1;
            el.style.transform = `translate3d(0, ${(y * speed).toFixed(2)}px, 0)`;
        });
        ticking = false;
    };

    window.addEventListener('scroll', () => {
        if (ticking) return;
        ticking = true;
        requestAnimationFrame(apply);
    }, { passive: true });

    apply();
}

/* ── Pointer-tracked card highlight ───────────────────────────────────
   Feeds the cursor position into --mx/--my so the card's internal wash
   follows the pointer. Skipped entirely on coarse pointers. */
function cardPointer(reduce) {
    if (reduce || !window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;

    document.querySelectorAll('.card').forEach((card) => {
        card.addEventListener('pointermove', (e) => {
            const r = card.getBoundingClientRect();
            card.style.setProperty('--mx', `${((e.clientX - r.left) / r.width) * 100}%`);
            card.style.setProperty('--my', `${((e.clientY - r.top) / r.height) * 100}%`);
        });

        card.addEventListener('pointerleave', () => {
            card.style.removeProperty('--mx');
            card.style.removeProperty('--my');
        });
    });
}

/* ── Counters ─────────────────────────────────────────────────────────
   Counts the leading number of a stat up when it scrolls into view. */
function counters(reduce) {
    const els = document.querySelectorAll('[data-count]');
    if (!els.length) return;

    if (reduce || !('IntersectionObserver' in window)) return; // markup already holds the final value

    const run = (el) => {
        const target = parseInt(el.dataset.count, 10);
        if (!Number.isFinite(target)) return;

        const suffix = el.dataset.countSuffix || '';
        const duration = 1100;
        const start = performance.now();

        const step = (now) => {
            const p = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - p, 3);
            el.textContent = `${Math.round(target * eased)}${suffix}`;
            if (p < 1) requestAnimationFrame(step);
        };

        requestAnimationFrame(step);
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            run(entry.target);
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.5 });

    els.forEach((el) => observer.observe(el));
}

/* ── Project filter ───────────────────────────────────────────────────*/
function projectFilter() {
    const buttons = document.querySelectorAll('[data-filter]');
    const cards = document.querySelectorAll('[data-category]');
    const empty = document.querySelector('[data-empty-state]');
    if (!buttons.length || !cards.length) return;

    buttons.forEach((button) => button.addEventListener('click', () => {
        const filter = button.dataset.filter;

        // aria-pressed is the single source of truth. Styling follows it via
        // Tailwind's aria-pressed: variant, so there is no class list to sync.
        buttons.forEach((b) => b.setAttribute('aria-pressed', String(b === button)));

        let shown = 0;
        cards.forEach((card) => {
            const match = filter === 'all' || card.dataset.category === filter;
            card.classList.toggle('hidden', !match);

            if (match) {
                shown++;
                // Re-run the rise so a filter change feels like a new deal,
                // not a jump cut.
                if (!reduced()) {
                    card.style.animation = 'none';
                    void card.offsetWidth;
                    card.style.animation = `riseIn .5s cubic-bezier(.2,.7,.2,1) ${Math.min(shown * 45, 320)}ms backwards`;
                }
            }
        });

        if (empty) empty.classList.toggle('hidden', shown !== 0);
    }));
}

document.addEventListener('DOMContentLoaded', () => {
    const reduce = reduced();
    currentYear();
    heroSequence(reduce);
    scrollReveals(reduce);
    parallax(reduce);
    cardPointer(reduce);
    counters(reduce);
    projectFilter();
});
