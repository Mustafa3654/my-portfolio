# Portfolio front-end

A distinctive dark-neutral design system for a Full-Stack Systems & Web Engineer
portfolio, written as modular Blade components for Laravel 13 + Tailwind CSS v4.

Open `preview.html` in a browser to see the finished page with no build step
(it loads Tailwind from a CDN and needs an internet connection). The Blade files
under `resources/views` are the real deliverable and render identically.

## Design direction

The subject is operational software — dispatch, orders, ledgers, receipts — so
the page borrows that vernacular rather than the usual developer-portfolio tropes.

| Axis | Choice |
| --- | --- |
| Ground | `#0C0F14` deep slate. Never `#000`, so hairlines stay readable |
| Surfaces | `#151A22` card, `#1C222C` raised, `#262E3A` hairline |
| Accent | `#F0B054` brass — the primary call to action |
| Category hues | apps `#4FB8C9` cyan · commerce `#F0B054` brass · tools `#9B8CF0` violet |
| Reserved | `#5FC98A` signal = *running*; `#DD8F66` clay = *problem / beta* |
| Display | Bricolage Grotesque, fluid to 8.5rem in the hero |
| Body | Instrument Sans |
| Utility | IBM Plex Mono for hostnames, labels and data |

Colour is **functional**, not decorative: a card's hue tells you its category
before you read the label. Depth comes from broad low-alpha tonal fields
(`.ambient`) and per-card gradients — never a bloom around an element.

**Signature element** — the *deployment board* in the hero: a hairline ops table
listing every live subdomain, what it serves, and a status dot. It states the
thesis ("these are running right now"), doubles as navigation, and puts the
custom subdomains front and centre.

**Structural device** — the hostname, not `01 / 02 / 03`. Nothing on this page is
a sequence, so numbering would be decoration. `wassili.mustafa.dev` identifies the
system *and* tells the reader where to click.

Deliberately excluded per the brief: neon glows, skill percentage bars, pure black,
floating context-free tech icons.

## File map

```
config/portfolio.php                  All content. One array per section.
resources/css/app.css                 @theme tokens + signature CSS
resources/js/portfolio.js             Reveals, board sequence, project filter
resources/views/
  layouts/portfolio.blade.php         Document shell
  pages/home.blade.php                Section order
  partials/                           nav · hero · spotlight · work · practice · contact · footer
  components/
    section-heading.blade.php         Eyebrow + title + lead
    status-pill.blade.php             live / in-use / beta / wip / private
    host-link.blade.php               subdomain rendered as an identifier
    board-row.blade.php               one deployment-board row
    project-card.blade.php            filterable grid card
    spotlight-card.blade.php          problem / solution case study
    flow-diagram.blade.php            hairline system diagram
preview.html                          Standalone static render
```

## Wiring it into Laravel

1. Copy `config/`, `resources/css/`, `resources/js/` and `resources/views/` into the app.

2. Point Vite at the entry files in `vite.config.js`:

   ```js
   laravel({ input: ['resources/css/app.css', 'resources/js/portfolio.js'], refresh: true })
   ```

3. Add the route:

   ```php
   Route::view('/', 'pages.home')->name('home');
   ```

4. Set the root domain once in `config/portfolio.php` (`'domain' => 'mustafa.dev'`).
   Every subdomain link across the board, the spotlight headers and the project
   cards is derived from it.

## Moving content to Filament

The config arrays are shaped like table rows, so each section can graduate to
Eloquent independently — the components don't change.

Given a `Project` model with `category`, `kind`, `name`, `summary`, `stack`,
`status`, `host` and `repo` columns, `partials/work.blade.php` becomes:

```php
$projects = \App\Models\Project::query()
    ->where('is_published', true)
    ->orderByDesc('sort_order')
    ->get();
```

and the `<x-project-card>` loop stays exactly as written. Same for
`board`, `spotlight` and `practice`.

Status values the components understand: `live`, `in-use`, `beta`, `wip`, `private`.

## Quality floor

- Responsive from 375px up; verified zero horizontal overflow at mobile width.
- `aria-pressed` is the single source of truth for the filter's active state —
  Tailwind's `aria-pressed:` variant does the styling, so there is no class list
  to keep in sync and screen readers get the real state.
- Visible brass focus ring on every interactive element.
- `prefers-reduced-motion` disables all reveals, the board stagger and the beacon.
- Reveal animations fail open: no `IntersectionObserver`, no JavaScript, or a
  stalled observer all leave the content visible.

## Content to confirm

- `domain` is a placeholder (`mustafa.dev`) — set your real root domain.
- `identity.cv` is `null`; set a path to show the CV row in the contact card.
- **AlphaDine** and **Feedback collector** have no repo descriptions on GitHub,
  so their copy is a best guess from the code and needs your review.
- **Recipes** is listed as beta/WIP with no repo yet.
- `CyberpunkExpress` (private Unity game) is not in the grid — it doesn't fit the
  three categories. Add a fourth category if you want it shown.
