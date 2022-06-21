```sh
composer require spatie/laravel-tags

php artisan vendor:publish --provider="Spatie\Tags\TagsServiceProvider" --tag="tags-config"

php artisan vendor:publish --provider="Spatie\Tags\TagsServiceProvider" --tag="tags-migrations"

php artisan migrate

composer require filament/spatie-laravel-tags-plugin
```

- config/tags.php

```php
'tag_model' => App\Models\Tag::class,
```

- Models

```php
use Spatie\Tags\HasTags;

class Post extends Model
{
    use HasTags;
```
