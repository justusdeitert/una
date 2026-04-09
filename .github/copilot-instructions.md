# Copilot Instructions for una

## Style

- Do not use em dashes (`—`, `U+2014`). Rephrase instead of substituting with hyphens.

## Overview

- WordPress theme for a single-page portfolio site using fullpage.js sections.
- SCF (Secure Custom Fields) blocks for content management.
- Vite + TypeScript for frontend assets with HMR in development.

## Tech Stack

- **Backend:** PHP, WordPress, SCF
- **Frontend:** TypeScript, SCSS, Vite
- **Libraries:** fullpage.js, PhotoSwipe, Draggable
- **Infrastructure:** Docker Compose (nginx, PHP-FPM, MariaDB, phpMyAdmin, Node)
- **Package manager:** yarn (inside Docker node container)
- **Tooling:** Biome (JS/TS lint + format), php-cs-fixer (PHP)

## Project Structure

- `theme/` - WordPress theme (`una-moehrke-theme`)
  - `functions.php` - Theme bootstrap, enqueues styles/scripts, shared helpers
  - `inc/` - PHP modules (SCF options, block registration, init hooks, TinyMCE config)
  - `acf-blocks/` - SCF block templates with `desktop/` and `mobile/` variants (folder kept for compatibility)
  - `acf-json/` - SCF field group JSON sync (folder kept for compatibility)
  - `template-parts/` - Reusable template partials (colors script, page wrapper, draggable)
  - `src/` - Frontend source (`ts/main.ts` + `ts/modules/`, SCSS, fonts, images)
  - `assets/` - Vite build output (production only, git-ignored)
  - `vite.config.ts` - Vite config and custom plugins
- `devops/` - Docker configuration (nginx, PHP, node Dockerfiles and scripts)
- `uploads/` - WordPress uploads directory
- `wordpress/` - WordPress core (git-ignored, installed via setup script)
- `.env` / `.env.dist` - Environment variables (DB credentials, WP setup, `FULLPAGE_LICENSE_KEY`)

## Development

- Runs via Docker Compose, controlled with `make` commands
- `make install` - Build containers and start
- `make start` / `make stop` - Start/stop containers
- `make dev` - Start Vite dev server (HMR on port 5173)
- `make build` - Production build via Vite
- `make analyze` - Production build with bundle visualizer
- `make enter_php` / `make enter_node` - Shell into containers
- `make setup_wordpress` - Install WordPress and configure site
- `make import_db` / `make export_db` - Database import/export with search-replace
- `make lint-php` / `make fix-php` - Run php-cs-fixer against the theme
- WordPress: http://localhost:8080 | Vite HMR: http://localhost:5173 | phpMyAdmin: http://localhost:8081

## Code Patterns

- SCF blocks have separate `desktop/` and `mobile/` template files.
- Asset loading auto-detects dev/prod in `functions.php`: if `theme/assets/` exists, built files are enqueued, otherwise the Vite dev server is loaded from the requesting host on port 5173.
- `window.themeConfig` is emitted in `wp_head` and carries runtime config like `fullpageLicenseKey` from the `.env` file.
- `node_modules` lives inside Docker volumes. Run installs inside the node container (`make enter_node`).
- TypeScript entry is `theme/src/ts/main.ts`, feature modules live in `theme/src/ts/modules/`.

## Installed Tools

- **CLI Tools:** git, gh (GitHub CLI), Docker, make, tree, wp-cli, imagemagick, ffmpeg
