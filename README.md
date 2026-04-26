
# Una 🎨

[![WordPress](https://img.shields.io/badge/WordPress-21759B?logo=wordpress&logoColor=white)](https://wordpress.org)
[![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)](https://www.php.net)
[![TypeScript](https://img.shields.io/badge/TypeScript-3178C6?logo=typescript&logoColor=white)](https://www.typescriptlang.org)
[![Vite](https://img.shields.io/badge/Vite-646CFF?logo=vite&logoColor=white)](https://vitejs.dev)
[![Sass](https://img.shields.io/badge/Sass-CC6699?logo=sass&logoColor=white)](https://sass-lang.com)
[![Docker](https://img.shields.io/badge/Docker-2496ED?logo=docker&logoColor=white)](https://www.docker.com)
[![Biome](https://img.shields.io/badge/Biome-60A5FA?logo=biome&logoColor=white)](https://biomejs.dev)

A WordPress theme and Docker dev environment powering the portfolio of performance artist Una Möhrke.

🌐 **Live:** [una-moehrke.de](https://www.una-moehrke.de)<br>
🧪 **Staging:** [una.justusdeitert.de](https://una.justusdeitert.de)

## Tech Stack

- **Backend:** WordPress, PHP, [SCF](https://wordpress.org/plugins/secure-custom-fields/) (Secure Custom Fields)
- **Frontend:** TypeScript, SCSS, [Vite](https://vitejs.dev) with HMR
- **Libraries:** [fullpage.js](https://alvarotrigo.com/fullPage/), [PhotoSwipe](https://photoswipe.com), [Draggable](https://shopify.github.io/draggable/)
- **Infrastructure:** Docker Compose (nginx, PHP-FPM, MariaDB, phpMyAdmin, Node)
- **Tooling:** [Biome](https://biomejs.dev) for JS/TS, php-cs-fixer for PHP

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

## License

Proprietary, all rights reserved. This repository is source-available but not open source. See [LICENSE](LICENSE) for details.
