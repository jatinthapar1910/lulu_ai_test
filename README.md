# Smart Ticket Triage

This project provides a minimal help‑desk app built with Laravel 11 and Vue 3. Users can submit tickets, queue an AI classification job and review the resulting tags. The UI is now a standalone Vue 3 app served directly from `public/index.html` without using Blade templates.

## Setup
1. Clone the repo and run `composer install` and `npm install`.
2. Copy `.env.example` to `.env` and set `APP_KEY` with `php artisan key:generate`.
3. Configure `OPENAI_API_KEY` and database settings in `.env`.
4. Run `php artisan migrate --seed` to create tables and seed sample data.
5. Start the queue worker `php artisan queue:work`.
6. Serve the application using `php artisan serve`.

## Assumptions & Trade-offs
- OpenAI integration can be disabled via `OPENAI_CLASSIFY_ENABLED=false` which falls back to random categories.
- Styling is simple BEM-based CSS without any framework.
- The front end is a small Vue app served from `public/index.html` on the `/` route.
