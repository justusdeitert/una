# AGENTS.md: guide for AI agents and contributors

WordPress theme for a single-page portfolio site built from fullpage.js sections. Classic theme with SCF (Secure Custom Fields) blocks, Vite + TypeScript + SCSS frontend, everything runs in Docker Compose and is controlled with `make`. Read this file first, then [README.md](README.md) and the [Makefile](Makefile).

## Golden rules

- **Never commit or push without explicit user confirmation.** The same applies to `make sync_to_*`, `make import_db*`, `make clean_install`, and anything else that overwrites data.
- Do not use em dashes (`—`, `U+2014`). Rephrase instead of substituting with hyphens.
- Don't modify `wordpress/` (core, git-ignored) or `theme/assets/` (build output).
- Use yarn inside the node container only, never npm or pnpm, and never install `node_modules` on the host.

## Tech stack

- **Backend:** PHP, WordPress, SCF
- **Frontend:** TypeScript, SCSS, Vite with HMR
- **Libraries:** fullpage.js, PhotoSwipe, Draggable
- **Infrastructure:** Docker Compose (nginx, PHP-FPM, MariaDB, phpMyAdmin, Node), Coolify for staging/production
- **Tooling:** Biome (TS lint + format), php-cs-fixer (PHP)

## Workspace map

```text
theme/                      WordPress theme (una-moehrke-theme)
  functions.php             Bootstrap, asset loading, shared helpers
  inc/                      PHP modules (SCF options, block registration, init hooks, TinyMCE config)
  acf-blocks/               SCF block templates with desktop/ and mobile/ variants (folder name kept for compatibility)
  acf-json/                 SCF field group JSON sync (folder name kept for compatibility)
  template-parts/           Partials (colors script, page wrapper, draggable, performance)
  src/ts/main.ts            TS entry, feature modules in src/ts/modules/
  src/scss/                 Styles, plus fonts/ and images/ next to it
  vite.config.ts            Vite config, custom plugins in vite-plugins/
  assets/                   Vite build output (git-ignored)
devops/
  Dockerfile                Multi-stage: node-base/php-base, dev targets node-dev/php-dev, prod php/nginx. Pins WP, WP-CLI, Composer, php-cs-fixer
  plugins.txt               Single source of truth for plugins (slug:version[:activate])
  nginx/conf.d/             nginx site config (dev and prod)
  php/wp-config.php         Env-driven wp-config for all environments (trusts Traefik forwarded headers)
  php/entrypoint.prod.sh    Prod entrypoint (WP install, plugin activation)
  php/php.prod.ini          Production PHP config
  scripts/                  setup-wordpress, db-export/import, sync-to-env/sync-from-env (+ sync-common)
db/                         Local DB dumps, mounted at /db in the php container
uploads/                    WordPress uploads (git-ignored)
.env.dist                   Env vars (DB credentials, WP setup, FULLPAGE_LICENSE_KEY); .env.prod.dist lists Coolify vars
docker-compose.yml          Local stack (docker-compose.prod.yml for Coolify staging and production)
```

## Development

| Command | Purpose |
|---|---|
| `make install` / `make start` / `make stop` | Build and (re)start / start / stop the stack |
| `make clean_install` | Fresh install, **removes volumes (local DB) and network** |
| `make dev` | Vite dev server (HMR on port 5173) |
| `make build` | Production build of theme assets |
| `make analyze` | Build with bundle visualizer, opens `stats.html` |
| `make setup_wordpress` | Install WordPress core and activate the theme |
| `make import_db` / `make export_db` (+ `_staging`) | DB import/export with domain search-replace |
| `make sync_to_staging` / `make sync_to_production` | Push local DB + uploads to Coolify |
| `make sync_from_staging` / `make sync_from_production` | Pull DB + uploads into the local stack |
| `make enter_php` / `make enter_node` / `make enter_phpmyadmin` | Shell into a container |

WordPress: http://localhost:8080, Vite: http://localhost:5173, phpMyAdmin: http://localhost:8081

## Code patterns

- SCF blocks have separate `desktop/` and `mobile/` template files; change both.
- Asset loading auto-detects dev/prod in `functions.php`: if `theme/assets/` exists, built files are enqueued from the Vite manifest, otherwise the Vite dev server is loaded from the requesting host on port 5173.
- `window.themeConfig` is emitted in `wp_head` and carries runtime config like `fullpageLicenseKey` from `.env`.
- Plugins are defined once in `devops/plugins.txt`; the dev setup script, prod Dockerfile and prod entrypoint all read it.
- Check template changes against the fullpage.js layout.
- UI-facing issues get "Verified on Safari desktop + iOS" as an acceptance criterion.

## Deployment (Coolify)

- Staging at https://una.justusdeitert.de and production at https://www.una-moehrke.de, both deployed from `main` as Docker Compose projects using `docker-compose.prod.yml`. They differ only in their Coolify env vars: `WP_ENVIRONMENT_TYPE` (`staging` or `production`) and `WORDPRESS_URL` are required, and `staging` keeps the site out of search engines.
- `devops/Dockerfile` builds the prod targets `php` (PHP-FPM with WordPress, plugins and theme) and `nginx` (static files).
- Env vars are set in the Coolify UI (see `.env.prod.dist`). Traefik terminates SSL; uploads and the database live in named volumes on the server.

## Before you finish a task

Run the checks that cover your change (stack must be running, `make start`):

- TS/SCSS: `docker compose exec node yarn lint` (fix with `yarn lint:fix`)
- PHP: `make lint_php` (fix with `make fix_php`)
- Build: `make build`

## Releases

- Bump `Version` in `theme/style.css` and `version` in `theme/package.json` and refresh the lockfile with `docker compose exec node yarn install`.
- Patch for fixes and refinements, minor for new features. Propose the version and wait for confirmation.
- Build with `make build`, then commit only the version files and lockfiles as `chore: release v<version>`, create a lightweight tag `v<version>` and push with `--tags` after confirmation, then publish a GitHub release (`GH_PAGER=cat gh release create v<version> --notes ...`) with Added/Fixed/Changed notes summarizing the commits since the last tag.

## Commits

- [Conventional Commits](https://www.conventionalcommits.org/): `feat:`, `fix:`, `refactor:`, `style:`, `perf:`, `test:`, `docs:`, `chore:`
- Title: short imperative summary, lowercase after the prefix (`feat: add image lazy loading`). Don't repeat the prefix as a verb (`fix: broken scroll`, not `fix: fix broken scroll`).
- Body only when needed: flat bullet list starting with capital letters, no category headers, max 10 items. Use `->` for version transitions (`bootstrap 4.2->4.3`).
- No `Co-authored-by` trailer for Copilot or any other AI.
