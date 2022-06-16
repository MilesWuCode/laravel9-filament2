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

# --generate:php artisan make:filament-resource Customer --generate
composer require doctrine/dbal
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
# CMS DB
CMS_DB_CONNECTION=mysql
CMS_DB_HOST=mysql
CMS_DB_PORT=3306
CMS_DB_DATABASE=laravel9_filament2
CMS_DB_USERNAME=sail
CMS_DB_PASSWORD=password

# CMS PATH
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

- config/database.php

```php
'cms' => [
    'driver' => 'mysql',
    'url' => env('CMS_DATABASE_URL'),
    'host' => env('CMS_DB_HOST', '127.0.0.1'),
    'port' => env('CMS_DB_PORT', '3306'),
    'database' => env('CMS_DB_DATABASE', 'forge'),
    'username' => env('CMS_DB_USERNAME', 'forge'),
    'password' => env('CMS_DB_PASSWORD', ''),
    'unix_socket' => env('CMS_DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
```

- app/Models/Admin.php

```sh
mv app/Models/User.php app/Models/Admin.php
```

```php
class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection = 'cms';
    protected $table = 'users';
```

- config/auth.php

```php
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\Admin::class,
    ],
],
```
