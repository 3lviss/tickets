# Ticketing System

A small ticket management application. The project demonstrates a simple full-stack MVC implementation with basic CRUD functionality, search/filtering, and database persistence using Laravel 12, Vue 3, and Inertia.js.

---

## Tech Stack

- **PHP 8.4+**
- **Laravel 12**
- **SQLite**
- **Eloquent ORM**
- **Vue 3**
- **Inertia.js**
- **Vite**
- **Tailwind CSS**
- **TypeScript**
- **Docker**
- **PHPUnit**

---

## Features

- Create, view, update, and delete tickets
- Ticket list with basic search and filtering
- Clear MVC structure following framework conventions
- Database migrations and seed data
- Simple, maintainable codebase

---

## Installation & Setup

### Docker Setup (Recommended)

Prerequisites: Docker & Docker Compose installed

```bash
# Clone the repository
git clone <repository-url>
cd <project>

# Build and start containers
docker-compose up --build
```

Application will be available at **http://localhost:8000**

### Manual Setup (without Docker)

Prerequisites: PHP 8.4+, Composer, Node 20+, SQLite

```bash
# Clone the repository
git clone <repository-url>
cd <project>

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
touch database/database.sqlite
php artisan migrate --seed

# Build assets and start server
npm run build
php artisan serve
```

Application will be available at **http://localhost:8000**

---

## Testing

```bash
# With Docker
docker-compose exec app php artisan test

# Without Docker
php artisan test
```

---

## Assumptions

- Single-user application (no authentication required per task specification)
- SQLite sufficient for expected data volume
- Server-side rendered views via Inertia (no separate API)
- Minimal styling — focus on functionality over visual polish

---

## Tradeoffs & Shortcuts

- **No authentication** — not in requirements, would add with Laravel's built-in Auth services
- **Single FormRequest class** — used one `TicketRequest` for store/update since validation rules are identical
- **SQLite database** — simplifies setup; would use PostgreSQL/MySQL for production
- **Minimal style** — focused on functionality; would improve UI/UX with more time

---

## Potential Next Steps

As the application scales and data volume increases, performance, reliability, and scalability become key priorities.

### 1. Caching

Reduces database load by storing frequently accessed data in memory. Essential for maintaining performance at scale.

### 2. Advanced Search (Elasticsearch)

As datasets grow, traditional database search becomes slow and limited. Introducing Elasticsearch enables fast, scalable full-text search with better relevance, filtering, and flexibility as search requirements evolve.

### 3. Background Jobs (Queues)

Heavy or time-consuming tasks run asynchronously to keep the user experience fast and responsive.

### 4. Search & Filtering Structure

As search and filtering logic grows, it can be gradually organized into dedicated classes or helpers. This improves readability and testability without requiring a full refactor into separate services upfront.

### 5. Filter State Persistence

Currently, search and filter parameters reset when navigating away from the list. Solutions:
- Store filters in URL query params (partially implemented)
- Use localStorage/sessionStorage for persistence
- State management store for cross-component state

### 6. Rate Limiting

Protects the application from abuse and ensures fair and predictable use of resources.

### 7. Database Optimization

As data grows, basic optimizations such as proper indexing, query tuning, and cleaning up old data help maintain good performance and stability.

### 8. User Authentication & Authorization

- User model with Laravel's built-in Auth services
- Role-based access control (admin, agent, user)
- Ticket ownership (user_id foreign key)