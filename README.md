
# una-moehrke.de

WordPress theme and Docker dev environment for [una-moehrke.de](https://www.una-moehrke.de), built with fullpage.js, SCF blocks, and Vite + TypeScript.

## Requirements

- Docker (with Docker Compose)
- GNU Make
- A fullpage.js license key (see [Configuration](#configuration))

## Quick Start

```bash
cp .env.dist .env        # adjust values as needed
make install             # build containers and start the stack
make setup_wordpress     # install WordPress core, activate theme
make dev                 # start Vite dev server with HMR
```

Services:

- WordPress: http://localhost:8080
- Vite HMR: http://localhost:5173
- phpMyAdmin: http://localhost:8081

## Configuration

Copy `.env.dist` to `.env` and fill in the values. The most important ones:

- `FULLPAGE_LICENSE_KEY`: fullpage.js license key. Get one at https://alvarotrigo.com/fullPage/pricing/.
- `WORDPRESS_ADMIN_USER` / `WORDPRESS_ADMIN_PASSWORD`: credentials created by `make setup_wordpress`.
- `LOCAL_DOMAIN` / `STAGING_DOMAIN` / `PRODUCTION_DOMAIN`: used by the DB import/export search-replace scripts.

## Make Targets

Run `make help` for the full list. Most used:

- `make install`: stop, build, and start all containers.
- `make start` / `make stop`: start or stop the stack.
- `make clean_install`: fresh install, removes volumes and network.
- `make dev`: run Vite dev server inside the node container.
- `make build`: production build of theme assets.
- `make analyze`: build with bundle visualizer, opens `stats.html`.
- `make setup_wordpress`: install WordPress core and activate the theme.
- `make import_db` / `make export_db`: DB import/export against the production domain.
- `make import_db_staging` / `make export_db_staging`: same, but against the staging domain.
- `make enter_php` / `make enter_node` / `make enter_phpmyadmin`: shell into the given container.
- `make lint_php` / `make fix_php`: run php-cs-fixer against the theme.

## Project Structure

```
theme/                 WordPress theme (una-moehrke-theme)
  functions.php        Theme bootstrap, enqueues, shared helpers
  inc/                 SCF options, block registration, init hooks, TinyMCE
  acf-blocks/          SCF block templates (desktop/ and mobile/ variants)
  acf-json/            SCF field group JSON sync
  template-parts/      Reusable template partials
  src/                 Frontend source (TypeScript, SCSS, fonts, images)
  assets/              Vite build output (git-ignored)
  vite.config.ts       Vite config and plugins
devops/                Docker config (nginx, PHP, node Dockerfiles, scripts)
uploads/               WordPress uploads (mounted into the container)
wordpress/             WordPress core (git-ignored, installed via make)
```

## Frontend

- Vite + TypeScript, SCSS compiled through Sass.
- Asset loading auto-detects dev vs prod: if `theme/assets/` exists, built files are enqueued, otherwise `functions.php` connects to the Vite dev server on port 5173.
- Linting and formatting via Biome: `yarn lint`, `yarn lint:fix`, `yarn format` inside the node container (`make enter_node`).

## Database

- `make import_db` reads `db-import.sql`, imports it, and runs a search-replace from `PRODUCTION_DOMAIN` to `LOCAL_DOMAIN`. Use `make import_db_staging` to swap `STAGING_DOMAIN` instead.
- `make export_db` dumps the current DB to `db-export.sql` with `LOCAL_DOMAIN` replaced by `PRODUCTION_DOMAIN`. Use `make export_db_staging` to target the staging domain.

## License

Proprietary, all rights reserved. This repository is source-available but not open source. See [LICENSE](LICENSE) for details.
