```sh
composer require spatie/laravel-medialibrary
composer require filament/spatie-laravel-media-library-plugin
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="config"
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="migrations"
php artisan migrate
```

- .env

```ini
MEDIA_DISK=public
```
