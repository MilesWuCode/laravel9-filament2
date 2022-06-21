```sh
composer require spatie/laravel-permission

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"

php artisan optimize:clear

php artisan migrate
```

- app/Models/Permission.php
- app/Models/Role.php
- config/permission.php

```php
// app/Models/Permission.php
<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as Model;

class Permission extends Model
{
    protected $connection = 'cms';
}

// app/Models/Role.php
<?php

namespace App\Models;

use Spatie\Permission\Models\Role as Model;

class Role extends Model
{
    protected $connection = 'cms';
}

// config/permission.php
'models' => [
    'permission' => App\Models\Permission::class,
    'role' => App\Models\Role::class,
]
```
