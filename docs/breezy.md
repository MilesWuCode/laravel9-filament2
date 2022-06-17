```sh
# install
composer require jeffgreco13/filament-breezy

# config
php artisan vendor:publish --tag="filament-breezy-config"

# layout
php artisan vendor:publish --tag="filament-breezy-views"
```

- config/filament.php

```php
"auth" => [
    "guard" => env("FILAMENT_AUTH_GUARD", "web"),
    "pages" => [
        "login" =>
            \JeffGreco13\FilamentBreezy\Http\Livewire\Auth\Login::class,
    ],
],
```
