# Laravel 11 CRUD Application - Copilot Instructions

## Project Overview
**Laravel 11 CRUD Application** for managing products with full Create, Read, Update, Delete operations using Laravel's resource controller pattern and Form Request validation.

**Tech Stack:**
- Laravel 11.x | PHP 8.2+ | Bootstrap 5 | MySQL
- Key Dependencies: `laravel/framework`, `laravel/tinker`, `laravel/pint`, `phpunit/phpunit`

## Architecture & Core Patterns

### Resource Controller Pattern
The entire CRUD is implemented via a single `ProductController` with Laravel's RESTful resource routes:
```php
// routes/web.php
Route::resource('products', ProductController::class);
```
All 7 HTTP methods (index, create, show, edit, store, update, destroy) are auto-routed. **Never add custom routes for product operations—extend the existing resource**.

### Form Request Validation (Not Controller)
- **Don't validate in controller**: Use dedicated `FormRequest` classes in `app/Http/Requests/`
- `ProductStoreRequest` and `ProductUpdateRequest` contain all validation rules
- Controllers call `$request->validated()` to get only validated data
- Example: `Product::create($request->validated())` never validates ad-hoc

### Model Layer
- `Product` model (`app/Models/Product.php`) uses `$fillable = ['name', 'detail']` for mass assignment
- Models are *thin*: leverage database migrations for schema definition
- Model factories in `database/factories/` for testing/seeding

### View Inheritance
- Base template: `resources/views/products/layout.blade.php` (extends `@yield('content')`)
- Individual views: `index.blade.php`, `create.blade.php`, `edit.blade.php`, `show.blade.php`
- Uses Bootstrap 5 + Font Awesome icons (CDN-based)
- Pagination uses Bootstrap 5 (set via `Paginator::useBootstrapFive()` in `AppServiceProvider`)

## Critical Workflows

### Database Operations
```bash
# Run migrations (creates products table with id, name, detail, timestamps)
php artisan migrate

# Create migration for schema changes
php artisan make:migration create_table_name --create=table_name

# Seed database (if adding test data)
php artisan tinker  # Interactive shell
>>> Product::factory(10)->create();
```

### Local Development
```bash
php artisan serve  # Runs on http://localhost:8000
# App auto-reloads on source changes
```

### Code Quality
```bash
# Format code (Laravel Pint)
./vendor/bin/pint

# Run tests (PHPUnit configured in phpunit.xml)
php artisan test
```

### Routes
```bash
# View all routes
php artisan route:list

# View products routes only
php artisan route:list --path=products
```

## Project-Specific Conventions

### Naming & Structure
- **Controllers**: `ProductController` → handles *Products* (singular resource type, plural class name)
- **Requests**: `ProductStoreRequest`, `ProductUpdateRequest` (separate for store/update—never combined)
- **Views**: Organized under `resources/views/products/` (lowercase, plural folder name matching resource)
- **Models**: `Product` in `app/Models/` (always singular)

### Response Patterns
- Successful operations redirect to `products.index` with session flash: `.with('success', 'Message')`
- Display flash in views via `@if($message = Session::get('success')) ... @endif`
- 404 errors handled automatically via route model binding (e.g., `/products/999` returns 404)

### Pagination & Listing
- Index controller paginates 5 items per page: `Product::latest()->paginate(5)`
- Pass pagination index to views: `->with('i', (request()->input('page', 1) - 1) * 5)`
- View displays item numbers sequentially across pages

## Common Tasks

### Adding a New Field to Products
1. Create migration: `php artisan make:migration add_field_to_products_table --table=products`
2. Add column in migration's `up()` method
3. Update `Product` model's `$fillable` array
4. Update `ProductStoreRequest::rules()` and `ProductUpdateRequest::rules()`
5. Update relevant Blade templates (create, edit, show)
6. Run: `php artisan migrate`

### Creating a New Resource (e.g., Categories)
1. Create model + migration: `php artisan make:model Category --migration`
2. Create controller: `php artisan make:controller CategoryController --resource --requests`
3. Add route: `Route::resource('categories', CategoryController::class)` in `routes/web.php`
4. Create Form Request classes: `app/Http/Requests/CategoryStoreRequest.php` and `...UpdateRequest.php`
5. Add views in `resources/views/categories/`

### Debugging
- Use `dd()` or `dump()` for variable inspection in controllers/views
- Check `storage/logs/laravel.log` for runtime errors
- Use `php artisan tinker` for interactive database queries

## Key Files Reference
- **Routing**: `routes/web.php`
- **Product Logic**: `app/Http/Controllers/ProductController.php`
- **Validation**: `app/Http/Requests/ProductStore/UpdateRequest.php`
- **Database**: `database/migrations/2024_03_12_142901_create_products_table.php`
- **UI Layout**: `resources/views/products/layout.blade.php`
- **Config**: `config/app.php` (database, pagination, etc.)
