# Netflow Analytics Dashboard

Netflow Analytics Dashboard is a Laravel-based web application that visualizes network traffic metrics in near real-time. It includes period-based filtering, automatic refresh, and chart export to CSV/PNG.

## Key Features

- Line charts for:
- `Cities`
- `Countries`
- `Destination Bytes`
- `Source Bytes`
- `Destination Packets`
- `Source Packets`
- `Destination IP`
- `Source IP`
- `Destination Ports`
- `Source Ports`
- Period filters: `1h`, `24h`, `7d`
- Auto-refresh every 5 seconds for `1h` views
- Export charts as `CSV` and `PNG`
- Internal API endpoints under `/api/v1/*` for chart refresh

## Tech Stack

- PHP `^8.3`
- Laravel `^12`
- Vite `^7`
- Tailwind CSS `^4`
- Alpine.js
- ApexCharts

## Requirements

- PHP 8.3+
- Composer
- Node.js + npm
- Analytics HTTP endpoints returning expected time-series payloads
- Docker + Docker Compose (optional, recommended for deployment)

## Local Setup (Non-Docker)

1. Clone this repository.
2. Install backend and frontend dependencies:

```bash
composer run setup
```

This command runs:
- `composer install`
- create `.env` from `.env.example` (if missing)
- `php artisan key:generate`
- `php artisan migrate --force`
- `npm install`
- `npm run build`

## Environment Configuration

Set the following values in `.env`:

```env
APP_TIMEZONE=Asia/Jakarta

ANALYTIC_CITIES_ENDPOINT=
ANALYTIC_COUNTRIES_ENDPOINT=
ANALYTIC_DESTINATION_AUTONOMOUS_BYTES_ENDPOINT=
ANALYTIC_SOURCE_AUTONOMOUS_BYTES_ENDPOINT=
ANALYTIC_DESTINATION_AUTONOMOUS_PACKETS_ENDPOINT=
ANALYTIC_SOURCE_AUTONOMOUS_PACKETS_ENDPOINT=
ANALYTIC_DESTINATION_IP_ENDPOINT=
ANALYTIC_SOURCE_IP_ENDPOINT=
ANALYTIC_DESTINATION_PORT_ENDPOINT=
ANALYTIC_SOURCE_PORT_ENDPOINT=
```

Notes:
- `APP_TIMEZONE` is used for chart time formatting.
- Every analytics endpoint should return a `data` payload compatible with the dashboard transformation logic.

## Run in Local Development

Start app server, queue listener, logs, and Vite in one command:

```bash
composer run dev
```

## Run with Docker

This project includes:
- Multi-stage `Dockerfile` (Composer + Vite build + Apache/PHP runtime)
- `docker-compose.yml` with:
- `app` service (web)
- `queue` service (worker)
- OPCache enabled for production runtime
- Named volumes for `storage` and SQLite `database`

### Required `.env` values for Docker

```env
APP_KEY=base64:...
APP_URL=http://localhost:8080
APP_ENV=production
APP_DEBUG=false

DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite

QUEUE_CONNECTION=database
SESSION_DRIVER=database
CACHE_STORE=database
```

Also configure all analytics endpoint variables listed above.

### Build and start containers

```bash
docker compose up -d --build
```

### Daily operations

```bash
docker compose ps
docker compose logs -f app
docker compose logs -f queue
docker compose exec app php artisan optimize:clear
docker compose down
```

### First boot (if `APP_KEY` is missing)

```bash
docker compose exec app php artisan key:generate
docker compose restart app queue
```

## How to Access in Browser

- Local (non-Docker): `http://127.0.0.1:8000/dashboard`
- Docker: `http://localhost:8080/dashboard`

## Docker Optimizations Included

- Multi-stage image build to separate build-time and runtime concerns
- Production Composer install (`--no-dev --optimize-autoloader`)
- Frontend assets built at image build time (`npm ci && npm run build`)
- OPCache enabled via `docker/php/opcache.ini`
- Runtime bootstrap via entrypoint: directory prep, migration, and config/view cache

## Internal API Endpoints

All endpoints accept `period` values: `1h`, `24h`, `7d`.

- `GET /api/v1/cities`
- `GET /api/v1/countries`
- `GET /api/v1/destination-autonomous-bytes`
- `GET /api/v1/source-autonomous-bytes`
- `GET /api/v1/destination-autonomous-packets`
- `GET /api/v1/source-autonomous-packets`
- `GET /api/v1/destination-ip`
- `GET /api/v1/source-ip`
- `GET /api/v1/destination-ports`
- `GET /api/v1/source-ports`

Export endpoint:
- `POST /chart/export` (`type=csv` or `type=png`)

## Testing

```bash
composer run test
```

## Project Structure (High Level)

- `app/Services/ElasticService.php` analytics API integration
- `app/Services/DashboardService.php` chart data transformation
- `resources/js/app.js` chart component, refresh, and export logic
- `resources/views/dashboard.blade.php` main dashboard view
