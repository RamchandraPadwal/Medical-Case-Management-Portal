# Medical Case Management (Intern Assignment)

A small web app where authorised users log in, create implant cases, update their status and see counts on a dashboard. Built with dummy data only.

**Tech stack:** Laravel, MySQL, Blade + Tailwind (Laravel Breeze), Laravel Sanctum (API tokens), PHPUnit, Git.

## Setup

```bash
git clone <your-repo-url> medical-case-manager
cd medical-case-manager
composer install
cp .env.example .env
php artisan key:generate
```

Create an empty MySQL database (for example `medical_cases`), then edit `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=medical_cases
DB_USERNAME=root
DB_PASSWORD=
SEED_PASSWORD=password
```

```bash
php artisan migrate --seed
npm install && npm run build
php artisan serve
```

Open http://127.0.0.1:8000

## Test login credentials (dummy)

| Role   | Email               | Password   |
|--------|---------------------|------------|
| Admin  | admin@example.com   | password   |
| Viewer | viewer@example.com  | password   |

(The password comes from `SEED_PASSWORD` in `.env`; the default is `password`.)

## Roles

| Role   | View | Create / edit / change status | Delete |
|--------|------|-------------------------------|--------|
| Admin  | Yes  | Yes                           | Yes    |
| Viewer | Yes  | No                            | No     |

Role checks live in `app/Policies/MedicalCasePolicy.php` and are enforced on the server (web and API), not just by hiding buttons.

## Running tests

```bash
php artisan test
```

Tests use an in-memory SQLite database (see `phpunit.xml`), so MySQL is not needed to run them.

## API

Base path `/api`. Send `Accept: application/json`. Protected routes need `Authorization: Bearer <token>`.

| Method | Endpoint         | Purpose                  | Who               |
|--------|------------------|--------------------------|-------------------|
| POST   | /api/login       | Get an API token         | Anyone            |
| POST   | /api/logout      | Revoke the current token | Logged-in users   |
| GET    | /api/cases       | List cases (10 per page, `?search=`, `?status=`, `?page=`) | Admin, Viewer |
| POST   | /api/cases       | Create a case            | Admin             |
| GET    | /api/cases/{id}  | Get one case             | Admin, Viewer     |
| PUT    | /api/cases/{id}  | Update a case            | Admin             |
| DELETE | /api/cases/{id}  | Delete a case            | Admin             |

Every response uses one shape:

```json
{ "success": true, "data": {}, "message": "..." }
```

Errors use `"success": false`; a 422 also has `"errors": { "field": ["message"] }`. Status codes used: 200, 201, 401, 403, 404, 422.

## Documentation

- `docs/database.md` - tables, columns, relationships
- `docs/traceability.md` - requirement to code to test
- `docs/deployment.md` - how I would host this on AWS (bonus)
- `docs/postman_collection.json` - exported Postman collection for all API endpoints

## Assumptions and known limitations

- Only two roles (Admin, Viewer). "Change status" is done through the edit form, so it is Admin-only.
- Patient reference is a dummy code; no real patient data is stored.
- No rate limiting on `/api/login` yet. Next step: add Laravel's `throttle` middleware to that route.
- No email verification or user management screen; users are created by the seeder.
- Deleting a case is permanent (no soft deletes). Next step: add `SoftDeletes` to keep an audit trail.
- Postman collection exported at `docs/postman_collection.json`.
