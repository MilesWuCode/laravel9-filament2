- .env

```ini
# MAIN DB
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=main
DB_USERNAME=sail
DB_PASSWORD=password

# CMS DB
CMS_DB_HOST=mysql
CMS_DB_PORT=3306
CMS_DB_DATABASE=cms
CMS_DB_USERNAME=sail
CMS_DB_PASSWORD=password

# CMS PATH
FILAMENT_PATH=/
```

- database/migrations/\*.php

```php
// add connection to cms
Schema:://...
// to
Schema::connection('cms')->
Schema::connection('mysql')->
```

- db.md

```sh
# migrate
php artisan migrate --database="cms" --path="database/migrations/cms"
php artisan migrate --database="mysql" --path="database/migrations/mysql"
```

```sh
# filament
composer require filament/filament

# config, --force
php artisan vendor:publish --tag=filament-config --force

# --generate:php artisan make:filament-resource Customer --generate
composer require doctrine/dbal

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

- config/filament.php

```php
// dark
'dark_mode' => true,

// logo
'footer' => [
    'should_show_logo' => false,
],

// width:null, 'xl', '7xl', 'full'
'max_content_width' => null,

// notify position
'notifications' => [
    'vertical_alignment' => 'bottom',
    'alignment' => 'right',
],

// collapsible
'is_collapsible_on_desktop' => true,
```

- upgrade

```sh
composer update

php artisan filament:upgrade
```

- config/database.php

```php
// cms連線
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
'passwords' => [
    'users' => [
        'provider' => 'users',
        'table' => env('CMS_DB_DATABASE').'.password_resets',
        'expire' => 60,
        'throttle' => 60,
    ],
],
```
