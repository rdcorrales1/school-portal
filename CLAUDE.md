# CLAUDE.md — Student Management Portal (Laravel)

Read this file before making any change. These rules apply to every task in this repo.

---

## Project

A Laravel school portal with login, a MariaDB/MySQL database (name not decided yet), and a small JSON API.

- Team of 4 novice developers, 3-hour build. Keep changes small and easy to explain.
- Demo runs locally with `php artisan serve`. AWS deployment is a stretch goal and is not part of the Must tier.

---

## Scope (Must first)

Build in this order. Do not start a Should or Stretch item until all Must items are merged.

### Must
- Login and logout.
- Three roles: `teacher`, `student`, `principal`. Each role lands on its own home page.
- Role check on every protected route. A wrong-role URL returns **403**.
- Teacher: add students (this also creates the student's login account), enter marks.
- Student: "My marks", showing only their own marks.
- Principal: read-only list of all students.
- API: `POST /api/login` returns a token. `GET /api/students` returns JSON for teacher and principal, with a valid token.
- At least 3 tests that pass with `php artisan test`.

### Should (only after Must is merged)
- `GET /api/my/marks` for the logged-in student.
- Form error messages under each field and success messages after saving.
- Phone-friendly layout (see the responsive rules in the UI section).

### Stretch
- AWS deployment, attendance, leave requests.

---

## Roles and permissions

- A role is a plain string column on `users`: `teacher`, `student`, or `principal`.
- `role` must **never** be mass-assignable. Do not put it in `$fillable`. Set it explicitly (`$user->role = 'student';`).
- A teacher can only manage students and enter marks for subjects they teach.
- A student can only see their own data. Student routes must **not** take a user or student ID from the URL. Use the logged-in user instead (for example `/my/marks`).
- A principal can view all students and teachers. A principal cannot change data in the Must tier.
- Use Policies or middleware for every access check. Never rely on hiding a button in the UI.

### Route groups
```php
Route::middleware(['auth', 'role:teacher'])
    ->prefix('teacher')->name('teacher.')
    ->group(function () { /* ... */ });
```
- Role middleware lives in `app/Http/Middleware/EnsureRole.php` and returns 403 for the wrong role.
- After login, redirect by role: `teacher.home`, `student.home`, `principal.home`.

---

## Database

- Must-tier tables: `users`, `students`, `subjects`, `marks`.
- Use string columns for `role` (not enums).
- Marks are whole numbers from 0 to 100. Only one mark per student, subject and quarter (unique index on `student_id, subject_id, quarter`).
- Never edit a migration that is already on `main`. Create a new migration instead.
- Run migrations in order. After pulling changes that include new migrations, run `php artisan migrate:fresh --seed`.
- When a teacher adds a student, create the `users` row and the `students` row together inside `DB::transaction`.

| Table | Key columns |
|---|---|
| `users` | name, email, password, role |
| `students` | user_id, student_no (e.g. `2026-00142`) |
| `subjects` | code (e.g. `CS-101`), name, teacher_id → users |
| `marks` | student_id, subject_id, quarter, mark (0–100) |

Seeder logins (demo only): `principal`, `teacher` and `student` accounts, all with password `password`. Passwords in the seeder are for local demo use only.

### `.env` (values stay local)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

---

## Code style

- Use Blade templates. Every view extends `layouts.app`. Do not write `<html>` or `<head>` in views.
- Bootstrap 5 from the CDN only. No npm, Vite, Tailwind, or extra CSS files.
- Forms: use `<label>`, `old()`, and `@error` for each field.
- Tables: use `@forelse` with an empty-state row.
- Never use `{!! !!}` for output. Use `{{ }}` so output is escaped.
- Validate input in Form Request classes, not inside controllers.
- Keep controllers thin. Put access rules in Policies.
- Use clear names. Avoid clever shortcuts a beginner cannot read.

### Folder layout
```
app/Http/Controllers/{Teacher,Student,Principal}/   # one folder per role
app/Http/Controllers/Api/                           # API controllers
app/Http/Middleware/EnsureRole.php
app/Http/Requests/
app/Policies/
resources/views/layouts/app.blade.php               # the only layout, holds design tokens
resources/views/auth/login.blade.php
resources/views/{teacher,student,principal}/
routes/web.php
routes/api.php
tests/Feature/
postman/school-portal.postman_collection.json
```

---

## UI & design system

Bootstrap 5 handles the grid, forms, tables and utilities. The brand look comes from CSS custom properties defined **once**, in a single `<style>` block inside `layouts/app.blade.php`. There are no separate CSS files.

**Rules**
1. Use `var(--...)` tokens for colors, fonts, spacing and radii. No raw hex colors anywhere except where the tokens are defined.
2. Prefer Bootstrap classes for layout (`row`, `col-*`, `d-flex`, `gap-*`, `table-responsive`). Use inline `style="..."` with tokens only when Bootstrap has no class for it.
3. Use the mono font for student IDs, subject codes, marks and timestamps.

### Tokens (define in `layouts.app`)
```css
:root {
  --bg-royal-blue: #1E3A8A;
  --surface-white: #FFFFFF;
  --surface-cool-gray: #F1F5F9;
  --accent-cyan: #06B6D4;
  --accent-cyan-hover: #0891B2;
  --text-dark: #0F172A;
  --text-muted: #64748B;
  --text-on-blue: #FFFFFF;
  --text-muted-on-blue: #CBD5E1;
  --border-cool-gray: #CBD5E1;
  --status-success: #10B981;
  --status-warning: #F59E0B;
  --status-error: #EF4444;

  --font-heading: 'Plus Jakarta Sans', sans-serif;
  --font-body: 'Inter', sans-serif;
  --font-mono: 'JetBrains Mono', monospace;

  --space-1: 4px;  --space-2: 8px;  --space-3: 12px; --space-4: 16px;
  --space-6: 24px; --space-8: 32px; --space-12: 48px; --space-16: 64px;
  --radius-md: 8px; --radius-lg: 12px; --radius-full: 9999px;
}
```
Load the fonts from Google Fonts in the layout `<head>`, next to the Bootstrap CDN link.

### Where each color goes
| Token | Use |
|---|---|
| `--bg-royal-blue` | Side nav, page canvas, login showcase panel |
| `--surface-white` | Cards, tables, modals, login form panel |
| `--surface-cool-gray` | Table headers, input backgrounds, right-side info panel |
| `--accent-cyan` (hover `--accent-cyan-hover`) | Primary buttons, active nav item, highlights |
| `--text-dark` / `--text-muted` | Text on white or gray |
| `--text-on-blue` / `--text-muted-on-blue` | Text on blue |
| `--status-success` / `--status-warning` / `--status-error` | Passed / Pending / Failed pills; Present / Late / Absent |

### Typography
| Level | Size / line-height / weight |
|---|---|
| H1 page title | 2.25rem / 1.2 / 700 (heading font) |
| H2 section / card header | 1.5rem / 1.3 / 600 |
| H3 card title | 1.125rem / 1.4 / 600 |
| Body | 1rem / 1.6 / 400 (body font) |
| Small / table cell | 0.875rem / 1.5 / 400 |

### Login page (`/login`)
- Two halves (`row g-0 min-vh-100`, each `col-lg-6`); stacks to one column below `lg`.
- **Left:** royal blue, padding `--space-12`: portal name → H1 "Student & Academic Management Portal" + muted subtitle → small cyan-accented feature card → school year badge.
- **Right:** white, centered form (max-width 400px): H2 "Portal Sign In", hint "Students, Teachers & Principal", email and password inputs, full-width cyan Sign In button.
- The login page does not show the side nav.

### Logged-in pages (`layouts.app`)
- **Desktop (≥1280px):** side nav 240px | main content | optional right info panel 320px.
- **Tablet:** side nav + main content; right panel moves below the content.
- **Phone (<768px):** one column. The side nav becomes a Bootstrap `offcanvas` opened by a menu button.
- **Side nav:** royal blue; links depend on the logged-in role; active link has a light cyan background, cyan text and a 3px cyan left border; the bottom shows name, role and a logout button (a POST form with `@csrf`).
- **Main content:** page H1 on the left and the main action button (e.g. `+ Add Student`) on the right; flash message below the header; content in white cards with radius `--radius-lg` and padding `--space-6`.

### Role menus
| Role | Links |
|---|---|
| Teacher | Home, Students, Marks |
| Student | Home, My Marks |
| Principal | Home, Students |

### Components
- **Tables:** inside a white card, wrapped in `.table-responsive`. Header row cool gray, muted text, uppercase 12px weight 600. IDs, codes and marks in mono.
- **Status pills:** `--radius-full`, padding `2px 10px`, 12px bold, light tinted background with the matching status color as text.
- **Inputs:** 40px tall, cool-gray background, 1px `--border-cool-gray` border, radius `--radius-md`, cyan focus outline. Use Bootstrap `is-invalid` + `invalid-feedback` with `@error`.
- **Buttons:** cyan background, white text, hover `--accent-cyan-hover`, radius `--radius-md`.

---

## API

- Use Laravel Sanctum token authentication (`php artisan install:api`, then check the output for any extra steps).
- Return JSON. Use proper status codes: 200 OK, 201 Created, 401 Unauthenticated, 403 Forbidden, 422 Validation error.
- Keep API responses to the fields the demo needs. Do not return password hashes or tokens in lists.
- Apply the same role rules as the web routes.
- Save the Postman collection in the repo at `postman/school-portal.postman_collection.json`.

---

## Tests

- Use Pest. Tests live in `tests/Feature/`, using `RefreshDatabase` and factories.
- Required tests:
  - A student gets 403 on a teacher URL.
  - A guest is redirected to login.
  - A principal can see the students list.
- Run `php artisan test` before every commit and before every PR.
- Do not delete or skip a failing test to make the build pass. Fix the code.

---

## Security

- Never commit `.env`. It must stay listed in `.gitignore`.
- Never put API keys, passwords or tokens in code, tests, README or chat messages.
- Use `.env.example` for the list of variable names, with empty values.
- Do not disable CSRF protection or add `$except` routes unless the team agrees.

---

## Git workflow

- `main` is protected. Changes reach `main` only through a reviewed pull request.
- Branch names: `feature/<short-name>` (for example `feature/teacher-students`).
- Commit messages: short and in the present tense (for example "Add student create form").
- One feature per PR. Keep PRs small. Open a PR within about 45 minutes of starting.
- Every team member must have at least one merged PR.
- Never use `git push --force` on `main`.

---

## How Claude should work in this repo

- Before changing code, read the relevant files and say which files you plan to change.
- Make one small change at a time. Run `php artisan test` after each change.
- Explain each change in plain words so the team member can answer questions about it.
- Do not add new packages without asking first.
- Do not change files outside the feature being worked on.
- If a request conflicts with these rules, say so and ask before proceeding.
- If a command fails, show the full error and suggest the smallest fix.
- Never paste or print the contents of `.env` in responses.

---

## Common commands

```
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan migrate:fresh --seed     # reset database with demo data
php artisan serve                    # http://127.0.0.1:8000
php artisan test
php artisan route:list               # see all routes
```

---

## Definition of done

- [ ] Feature works when logged in as each relevant role.
- [ ] Wrong-role access returns 403.
- [ ] Page uses `layouts.app` and the design tokens.
- [ ] `php artisan test` passes.
- [ ] `php artisan migrate:fresh --seed` runs with no errors.
- [ ] No secrets in the diff.
- [ ] PR opened and reviewed by one other team member.