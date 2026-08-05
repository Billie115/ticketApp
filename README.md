# Help / Ticket Tracker

A ticketing system built with **Laravel 13** that lets a company offer ticket submission and management to both its customers and its staff. Customers can submit and track issues without an account; staff log in to manage those tickets from a dashboard.

Built as a learning project (part of a degree program) to practice core Laravel concepts: migrations, Eloquent relationships, validation, routing, Blade layouts, file uploads, mail, and authentication.

## Tech Stack

- **Framework:** Laravel 13
- **Language:** PHP 8.4
- **Database:** SQLite
- **Auth:** Laravel Breeze (Blade)
- **Views:** Blade templates, styled with [XP.css](https://botoxparty.github.io/XP.css/) for a Windows XP look
- **Local environment:** Laravel Herd
- **Email testing:** Mailhog (SMTP catcher)

## Getting Started

```bash
# Install PHP dependencies
composer install

# Install JS dependencies and build assets (required for the login/register pages)
npm install
npm run build

# Environment file
cp .env.example .env
php artisan key:generate

# Build the schema and seed initial data (categories + a test staff user)
php artisan migrate:fresh --seed

# Create the storage symlink (needed for uploaded files to be viewable)
php artisan storage:link

# Run the development server
php artisan serve
```

The app will be available at `http://127.0.0.1:8000`.

### Email (optional, for testing the notification email)

The app sends an email with a tracking link when a ticket is submitted. To see these emails locally:

1. Download [Mailhog](https://github.com/mailhog/MailHog/releases) and run it (`mailhog.exe`, or the equivalent for your OS).
2. Make sure `.env` has:
   ```
   MAIL_MAILER=smtp
   MAIL_HOST=127.0.0.1
   MAIL_PORT=1025
   ```
3. View caught emails at `http://localhost:8025`.

If Mailhog isn't running, switch `MAIL_MAILER` to `log` in `.env` instead, and read the sent email from `storage/logs/laravel.log`.

## How to Test This Project

### As a customer (no account needed)

1. Go to `http://127.0.0.1:8000/submit`.
2. Fill in a title, category, email, description, and optionally attach files (pdf/png/jpg, max 10MB each).
3. Submit — you'll be redirected to the ticket's page, and (if Mailhog is running) an email with the same link will appear in Mailhog.
4. From the ticket page you can view all details, download attachments, and add comments.

### As staff

Log in at `http://127.0.0.1:8000/login` with the seeded test account:

- **Email:** `test@example.com`
- **Password:** `password`

After logging in you're taken to `/staff/tickets`, where you can:

- See all tickets, with filters for **status** and **tracking code**.
- Open a ticket to change its status, assign it to a staff member, upload attachments, and add comments.

You can register additional staff accounts at `/register` to test ticket assignment between multiple staff members.

## Data Model

- **Category** — the type of issue (e.g. Technical problem, Account, Payment). Has many tickets.
- **Ticket** — the core entity. Belongs to a category, is optionally assigned to a staff user, and has many comments and attachments. Each ticket carries a human-friendly `tracking_code` (e.g. `Tick-DQ2ZTF`) and an unguessable `uuid` used in public links.
- **Comment** — a message on a ticket. Belongs to a ticket, and optionally to a user. A `null` user means the comment came from a customer (no login); a set user means it came from staff.
- **Attachment** — an uploaded file linked to a ticket. The file itself is stored on disk (`storage/app/public`); only its path and metadata live in the database.
- **User** — a staff account (Laravel's built-in user model, used for authentication and ticket assignment).

### Ticket fields

| Field | Description |
|-------|-------------|
| `uuid` | Unguessable identifier used in public URLs |
| `tracking_code` | Short, human-readable code (e.g. `Tick-DQ2ZTF`) |
| `title` | Ticket title |
| `description` | Detailed description (optional) |
| `email` | Customer email (where the tracking link is sent) |
| `category_id` | The category the ticket belongs to |
| `assigned_to` | The staff member handling it (null until assigned) |
| `status` | `in_progress`, `completed`, or `cancelled` |

## Features

- **Public ticket submission** — login-free form for title, category, email, description, and file attachments (pdf/png/jpg).
- **Automatic identifiers** — every ticket generates its own `uuid` and `tracking_code` on creation.
- **Email notification** — customer receives an email with a link to their ticket after submitting.
- **Public ticket view** — reached through the ticket's `uuid`; shows all fields, attachments (with image previews), and comments. An unknown uuid returns a 404.
- **Customer comments** — customers can comment on their own ticket without an account.
- **Staff authentication** — login/register/logout via Laravel Breeze; `/staff/*` routes require login.
- **Staff dashboard** — list of all tickets with filters for status and tracking code.
- **Ticket management** — staff can change a ticket's status, assign it to a staff member, upload additional attachments, and add comments (shown with the staff member's name).
- **Windows XP styled UI** — all customer-facing and staff pages, plus login/register, share a common Blade layout (`layouts/xp.blade.php`) styled with XP.css.

### Not yet implemented

- Automated tests.
- Email queueing (currently sent synchronously on submission).

## Useful Routes

| Method | URL | Access | Purpose |
|--------|-----|--------|---------|
| GET | `/submit` | Public | Show the ticket submission form |
| POST | `/submit` | Public | Store a new ticket |
| GET | `/ticket/{uuid}` | Public | View a ticket and its comments/attachments |
| POST | `/ticket/{uuid}/comment` | Public | Add a customer comment |
| GET | `/login`, `/register` | Public | Staff authentication |
| GET | `/staff/tickets` | Staff (auth) | List/filter all tickets |
| GET | `/staff/tickets/{id}` | Staff (auth) | Manage a single ticket |
| PATCH | `/staff/tickets/{id}` | Staff (auth) | Update status / assignment |
| POST | `/staff/tickets/{id}/comment` | Staff (auth) | Add a staff comment |
| POST | `/staff/tickets/{id}/attachment` | Staff (auth) | Upload additional files |

## Notes on the Windows Environment

This project was built on Windows with Laravel Herd. Two PHP settings needed adjusting in `php.ini` (`C:\Users\<user>\.config\herd\bin\php84\php.ini`) for file uploads to work correctly:

```ini
upload_tmp_dir = "C:\herd-tmp"
upload_max_filesize = 20M
post_max_size = 20M
```

(with a matching `C:\herd-tmp` folder created on disk). This shouldn't be needed on other setups, but is noted here in case uploads fail with a generic "failed to upload" error.