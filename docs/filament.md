- install

```sh
# laravel
curl -s "https://laravel.build/laravel9-filament2" | bash

# migrate
php artisan migrate

# filament
composer require filament/filament

# config, --force
php artisan vendor:publish --tag=filament-config --force

# make user
php artisan make:filament-user

# open
open http://localhost/admin
```

- composer.json

```json
"post-update-cmd": [
    // ...
    "@php artisan filament:upgrade"
],
```

- routes/api.php & routes/web.php

```php
// disabled
// Route::...
```

- .env

```ini
FILAMENT_PATH=/
```

- config/filament.php

```php
'dark_mode' => true,
```

- upgrade

```sh
composer update

php artisan filament:upgrade
```
