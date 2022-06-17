```sh
composer require saade/filament-laravel-log

php artisan vendor:publish --tag="log-config"
```

- config/filament-laravel-log.php

```php
'authorization' => true,
```

- app/Providers/AppServiceProvider.php

```php
use Saade\FilamentLaravelLog\Pages\ViewLog;
use App\Models\Admin;

public function boot()
{
    ViewLog::can(function (Admin $user) {
        return true;
    });
}
```
