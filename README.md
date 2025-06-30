# Expenses Module for Laravel 12

## Overview

This module provides a **self-contained Expenses feature** for a Laravel 12 application. It includes:

- CRUD operations for Expenses via API routes  
- Expenses have fields: UUID `id`, `title`, `amount`, `category` (enum), `expense_date`, optional `notes`, timestamps  
- Form Request validation for input  
- Eloquent Models with UUID primary keys  
- Service Layer for business logic separation  
- Event `ExpenseCreated` dispatched on new expense creation  
- Listener to send database notification (`ExpenseCreatedNotification`) to the expense owner  
- No authentication method implemented
- Laravel Resource classes for consistent API response formatting  
- OpenAPI (Scribe) documentation annotations

---

## Setup Instructions

### 1. Clone or copy the module into `Modules/Expenses` directory

Make sure your Laravel app supports module loading, via `composer require nwidart/laravel-modules`.

change the ff config into `composer.json`: add `"Modules\\": "Modules/"`
```json
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Modules\\": "Modules/",
            ...
```

Then copy the `Expenses` module files into the `Modules/Expenses` directory. The structure should look like this:
Add `modules_statuses.json` into the root directory:
```json
{
    "Expenses": true
}
```

```bash
composer dump-autoload
```

### 2. Run migrations

Ensure your database is set up and configured in `.env`. Then run the following commands to create the necessary tables:
notifications table is used to store database notifications for the expenses module.

```bash
php artisan notifications:table
php artisan migrate
```

### 3. Used Scribe if needed (e.g., Scribe docs)

```bash
composer require knuckleswtf/scribe --dev
php artisan vendor:publish --tag=scribe-config
```
// config/scribe.php
```php
'routes' => [
    [
        'match' => [
            'prefixes' => ['api'],
            'domains' => ['*'],
        ],
        'include' => base_path('Modules/Expenses/Routes/api.php'),
    ],
],
```

To generate the docs
```bash
php artisan scribe:generate
```

You will get the generated docs in `/docs` link.

### 4. Run tests

One test is created for the Expenses module to ensure the API create behaves as expected. Run the following command:

```bash
php artisan test Modules/Expenses/tests/Feature/ExpensesTest.php
```

### 5. API Usage

- Create expense: `POST /api/expenses`  
- List expenses: `GET /api/expenses` or
- optional filter `GET /api/expenses?category=food,health&date_from=2025-01-01&date_to=2025-12-31`
- View expense: `GET /api/expenses/{id}`  
- Update expense: `PUT /api/expenses/{id}`  
- Delete expense: `DELETE /api/expenses/{id}`

---

## Structure & Design Decisions

- **Modules**: Used Laravel Modules pattern for separation and scalability.  
- **UUID Primary Keys**: All expenses use UUIDs for uniqueness and security.  
- **Form Requests**: Validation logic is encapsulated in Form Request classes.  
- **Service Layer**: All business logic related to expenses is in a Service class to keep controllers thin and reusable.  
- **Events & Listeners**: On expense creation, an event triggers a listener that sends a database notification to the user. This decouples side effects from core logic.  
- **Repository Pattern (Optional)**: Not used here to keep it simple but can be added if needed.  
- **Resource Classes**: Responses use Laravel API Resource for consistent, clean JSON output.  
- **Testing**: Feature a test cover API behavior.  
- **Scribe Docs**: Inline annotations generate OpenAPI documentation automatically.

---

## Assumptions Made

- Each expense is owned by a user (`user_id` foreign key), and users receive notifications.  
- Categories are simple enums or strings, no separate category module.  
- Notification via database only; email or other channels can be added later.  
- Frontend or client consuming API handles displaying notifications and their state.  
- Laravel 12 environment with `nwidart/laravel-modules` installed and configured.  

---

## Time Spent

Approximately **6 hours** including:

- Designing module structure  
- Writing migrations, models, controllers, services  
- Implementing events, listeners, and notifications  
- Writing feature tests  
- Adding Scribe documentation  
- Debugging and testing database notifications  

---


### Run the application locally:
```bash
php artisan serve
```
# Access the application:
Open your web browser and go to:
```
http://localhost:8000
```
 
---
