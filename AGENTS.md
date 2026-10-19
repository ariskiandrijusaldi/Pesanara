# AGENTS.md

Laravel 13 app — stock `laravel/laravel` skeleton, single package (no monorepo), no custom code yet (welcome route, example tests only). PHP ^8.3, PHPUnit 12, Vite 8 + Tailwind 4, SQLite, composer scripts + npm. Dev shell here is Windows/PowerShell.

## Setup (fresh clone)

```sh
composer setup
```

Runs: `composer install` -> copy `.env.example` -> `key:generate` -> `migrate --force` -> `npm install --ignore-scripts` -> `npm run build`.

Gotcha: `database/database.sqlite` is not committed and `setup` does NOT create it — `migrate` throws `SQLiteDatabaseDoesNotExistException` until it exists:

```sh
php -r "touch('database/database.sqlite');"
```

## Commands

- `vendor/bin/pint` — formatter (Pint, default Laravel preset; no `pint.json`, no composer script, no CI). Run before finishing.
- `composer test` — runs `config:clear`, then `php artisan test`. Single test: `php artisan test --filter=<name>` or pass a path (`php artisan test tests/Feature/ExampleTest.php`).
- Verification loop is pint -> test. No static analysis (PHPStan is not a direct dependency), no CI workflows, no git hooks.
- `composer dev` — `php artisan dev`: `serve` + `queue:listen` + Vite in one multiplexed view (via `concurrently` on Windows — that is why it is in package.json). Needs `.env`, `vendor/`, `node_modules/`.
- `npm run dev` / `npm run build` — Vite only.

## Testing quirks

- `phpunit.xml` pins tests to SQLite `:memory:`, array cache/session, sync queue — tests never read your `.env` DB or touch `database/database.sqlite`. Use `RefreshDatabase` for DB tests.
- `composer test` clears `bootstrap/cache/config.php` first so cached `.env` values cannot override phpunit.xml env vars. If you run `vendor/bin/phpunit` directly, clear config yourself after changing `.env`.
- `laravel/pao` (dev dep) rewrites test output for detected AI agents — expect machine-oriented output instead of normal PHPUnit rendering.

## Notes

- README and `CLAUDE.md` direct agents to install Laravel Boost (`composer require laravel/boost --dev && php artisan boost:install`). Warning: `boost:install` regenerates this file.
