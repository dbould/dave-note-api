# API for interacting with Dave Note database
This handles CRUD operations for the React interface: [https://github.com/dbould/dave-note-interface](https://github.com/dbould/dave-note-interface)

## Set up
`php artisan key:generate`
`php artisan config:cache`

## Clearing cache
`php artisan route:cache`
`php artisan config:cache`
`php artisan cache:cache`

## Run Migrations
From project root:

```php artisan migrate```
