# Pushing changes

Commands are listed one per line on purpose. This machine's shell is Windows
PowerShell 5.1, where `&&` is a parser error rather than a chain operator — so
`git add -A && git commit -m "..."` fails before it runs anything. Paste them one
at a time.

## Everyday loop

See what changed:

```bash
git status
```

Stage everything:

```bash
git add -A
```

Commit:

```bash
git commit -m "describe what changed"
```

Push:

```bash
git push
```

`git push` needs no arguments — the branch already tracks `origin/main`.

If you want to read the actual changes before committing:

```bash
git diff
```

## What is deliberately not committed

| Path | Why |
| --- | --- |
| `.env` | Holds `APP_KEY` and the database credentials. `.env.example` is the tracked template. |
| `legacy/DB/` | The old plain-PHP dump contains an admin `password_hash`, plus a phone number and date of birth. |
| `public/build/` | Compiled CSS and JS. Laravel ignores this by default. |
| `vendor/`, `node_modules/` | Restored by `composer install` and `npm install`. |

Because `public/build/` is ignored, **you do not need to run `npm run build`
before committing.** The build output never enters the repository — which is
exactly why a fresh clone has to build once, below.

## Fresh clone setup

Anyone cloning the repo (including you, on another machine) runs these once:

```bash
composer install
```

```bash
npm install
```

```bash
cp .env.example .env
```

```bash
php artisan key:generate
```

`.env.example` already points at MySQL and the `my_portfolio` database, so
create that database in phpMyAdmin first, then:

```bash
php artisan migrate
```

```bash
php artisan db:seed
```

The seeders populate the profile, all projects, experience, education,
capabilities and documents from `config/portfolio.php`, so the site is not empty
on first run.

Build the assets:

```bash
npm run build
```

Then serve it:

```bash
php artisan serve
```

You will also need an admin login, since the users table starts empty:

```bash
php artisan make:filament-user
```

## Publishing it through a tunnel

See the "Exposing it publicly" section of [README-FRONTEND.md](README-FRONTEND.md).
