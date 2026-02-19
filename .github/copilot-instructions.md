# Copilot Instructions for una

## Style

- Do not use em dashes (`—`, `U+2014`). Rephrase instead of substituting with hyphens.

## Overview

- WordPress theme for a single-page portfolio site using fullpage.js sections.
- ACF (Advanced Custom Fields) blocks for content management.
- Vite for frontend asset bundling with HMR in development.

## Tech Stack

- **Backend:** PHP, WordPress, ACF Pro
- **Frontend:** JavaScript (jQuery), SCSS, Vite
- **Libraries:** fullpage.js, Bootstrap 4, SmartPhoto, SidebarJS, Slick Carousel, Draggable
- **Infrastructure:** Docker Compose (nginx, PHP-FPM, MySQL, phpMyAdmin, Node)
- **Package manager:** yarn (inside Docker node container)

## Project Structure

- `theme/` - WordPress theme (`una-moehrke-theme`)
  - `functions.php` - Theme bootstrap, enqueues styles/scripts, includes
  - `inc/` - PHP modules (ACF options, block registration, init hooks, TinyMCE config)
  - `acf-blocks/` - ACF block templates with `desktop/` and `mobile/` variants
  - `acf-json/` - ACF field group JSON sync
  - `template-parts/` - Reusable template partials (colors script, page wrapper, draggable)
  - `src/` - Frontend source (JS modules, SCSS, fonts, images)
  - `assets/` - Vite build output (production only, git-ignored)
- `devops/` - Docker configuration (nginx, PHP, Node Dockerfiles)
- `uploads/` - WordPress uploads directory
- `wordpress/` - WordPress core (git-ignored, installed via setup script)

## Development

- Runs via Docker Compose, controlled with `make` commands
- `make install` - Build containers and start
- `make start` / `make stop` - Start/stop containers
- `make dev` - Start Vite dev server (HMR on port 5173)
- `make build` - Production build via Vite
- `make enter_php` / `make enter_node` - Shell into containers
- `make setup_wordpress` - Install WordPress and configure site
- `make import_db` / `make export_db` - Database import/export with search-replace
- WordPress: http://localhost:8080 | Vite HMR: http://localhost:5173 | phpMyAdmin: http://localhost:8081

## Code Patterns

- ACF blocks have separate `desktop/` and `mobile/` template files
- Asset loading auto-detects dev/prod: if `assets/` folder exists, load built files; otherwise, connect to Vite dev server
- `node_modules` lives inside Docker volumes. Run installs inside the node container (`make enter_node`)

## Installed Tools

- **CLI Tools:** git, gh (GitHub CLI), Docker, make, tree, wp-cli, imagemagick, ffmpeg
