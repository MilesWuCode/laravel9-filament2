```sh
composer require spatie/laravel-activitylog

php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"

php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-config"

composer require z3d0x/filament-logger

php artisan vendor:publish --tag="filament-logger-config"
```

- .env

```ini
# activitylog
ACTIVITY_LOGGER_DB_CONNECTION=cms
```

```sh
php artisan migrate
```
