# Clarion App Lists Backend

This package provides an API to create and manage lists (TODO lists, grocery lists, etc).

## Installation

1. Require the package in your Laravel application:

    ```bash
    composer require clarion-app/lists-backend
    ```

2. Run the migrations:

    ```bash
    php artisan migrate
    ```

## Usage

The package provides the following API endpoints:

- `GET /api/clarion-app/lists` - List all lists
- `POST /api/clarion-app/lists` - Create a new list
- `GET /api/clarion-app/lists/{id}` - Get a specific list
- `PUT /api/clarion-app/lists/{id}` - Update a specific list
- `DELETE /api/clarion-app/lists/{id}` - Delete a specific list
- `POST /api/clarion-app/lists/{id}/clone` - Clone a specific list
