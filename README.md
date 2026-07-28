# Help / Ticket Tracker

A ticketing system built with **Laravel 13** that lets a company offer ticket submission and management to both its customers and its staff. Customers can submit and track issues without an account; staff manage those tickets from an authenticated dashboard.

This project is being developed as a learning project (part of a degree program) to practice core Laravel concepts: migrations, Eloquent relationships, validation, routing, Blade views, file uploads, mail, and authentication.

## Tech Stack

- **Framework:** Laravel 13
- **Language:** PHP 8.4
- **Database:** SQLite (portable to MySQL with a config change)
- **Views:** Blade templates
- **Local environment:** Laravel Herd

## Data Model

The system is built around four related entities.

- **Category** — the type of issue (e.g. Technical problem, Account, Payment). Has many tickets.
- **Ticket** — the core entity. Belongs to a category, is optionally assigned to a staff user, and has many comments and attachments. Each ticket carries a human-friendly `tracking_code` and an unguessable `uuid` used in public links.
- **Comment** — a message on a ticket. Belongs to a ticket, and optionally to a user. A `null` user means the comment came from a customer (no login); a set user means it came from a staff member.
- **Attachment** — an uploaded file linked to a ticket. The file itself is stored on disk; only its path and metadata live in the database.

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

### Implemented

- **Public ticket submission** — a login-free form where a customer submits a title, category, email, and description. Input is validated server-side before anything is saved.
- **Automatic identifiers** — every new ticket generates its own `uuid` and `tracking_code` automatically on creation.
- **Public ticket view** — a per-ticket page reached through the ticket's `uuid`. It shows all ticket fields and its comments. The unguessable uuid prevents customers from browsing other people's tickets; an unknown uuid returns a 404.
- **Customer comments** — customers can add comments to their ticket directly from the ticket page, without an account.

### Planned

- **File attachments** — allow customers to upload files (PDF, PNG, JPG, etc.) with a ticket, stored on disk with references kept in the database.
- **Email notifications** — email the customer a link to open and track their ticket after submission.
- **Staff authentication** — login for company employees.
- **Staff dashboard** — a list of tickets with filters for **status** and **tracking code**.
- **Ticket management** — from an individual ticket, staff can change status, assign the ticket, upload files, and add comments.
- **Automated tests** — feature tests covering submission and the core flows.

## Getting Started

```bash
# Install dependencies
composer install

# Create your environment file
cp .env.example .env
php artisan key:generate

# Create the SQLite database file (if it doesn't exist)
# then build the schema and seed initial categories
php artisan migrate:fresh --seed

# Run the development server
php artisan serve
```

The app will be available at `http://127.0.0.1:8000`.

### Useful routes

| Method | URL | Purpose |
|--------|-----|---------|
| GET | `/submit` | Show the ticket submission form |
| POST | `/submit` | Store a new ticket |
| GET | `/ticket/{uuid}` | View a ticket by its uuid |
| POST | `/ticket/{uuid}/comment` | Add a customer comment |

## Project Status

Core public-facing flow (submit → view → comment) is complete. Attachments, email, and the full staff side are in progress.