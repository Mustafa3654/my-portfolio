/*
| Portfolio front-end behaviour
|
| Three jobs: reveal sections on scroll, run the deployment board's load
| sequence, and filter the project grid. Everything degrades to visible,
| usable content if any of it fails.
*/

const prefersReducedMotion = () =>
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

function currentYear() {
    const el = document.querySelector('[data-current-year]');
    if (el) el.textContent = new Date().getFullYear();
}

function scrollReveals(reduce) {
    const reveals = document.querySelectorAll('.reveal');
    if (!reveals.length) return;

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
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.06 });

    reveals.forEach((el) => observer.observe(el));

    // Content must never stay stuck at opacity 0. Anything already inside the
    // viewport is force-revealed shortly after load if the observer hasn't run.
    setTimeout(() => {
        reveals.forEach((el) => {
            if (el.getBoundingClientRect().top < window.innerHeight) {
                el.classList.add('in');
            }
        });
    }, 1200);
}

function deploymentBoard(reduce) {
    document.querySelectorAll('.board-row').forEach((row, index) => {
        if (reduce) {
            row.classList.add('in');
            return;
        }
        setTimeout(() => row.classList.add('in'), 260 + index * 95);
    });
}

function projectFilter() {
    const buttons = document.querySelectorAll('[data-filter]');
    const cards = document.querySelectorAll('[data-category]');
    const empty = document.querySelector('[data-empty-state]');
    if (!buttons.length || !cards.length) return;

    buttons.forEach((button) => button.addEventListener('click', () => {
        const filter = button.dataset.filter;

        // aria-pressed is the single source of truth. Styling follows it through
        // Tailwind's aria-pressed: variant, so there is no class list to sync.
        buttons.forEach((b) => b.setAttribute('aria-pressed', String(b === button)));

        let shown = 0;
        cards.forEach((card) => {
            const match = filter === 'all' || card.dataset.category === filter;
            card.classList.toggle('hidden', !match);
            if (match) shown++;
        });

        if (empty) empty.classList.toggle('hidden', shown !== 0);
    }));
}

document.addEventListener('DOMContentLoaded', () => {
    const reduce = prefersReducedMotion();
    currentYear();
    scrollReveals(reduce);
    deploymentBoard(reduce);
    projectFilter();
});
