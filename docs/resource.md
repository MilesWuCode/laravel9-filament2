- view

```sh
php artisan make:filament-resource User --view --generate
php artisan make:filament-page ViewAdmin --resource=AdminResource --type=ViewRecord
```

```php
public static function getPages(): array
{
    return [
        // ...
        'view' => Pages\ViewAdmin::route('/{record}'),
    ];
}
```

- icon

```sh
open https://heroicons.com
```

- single

```php
class AdminResource extends Resource
{
    protected static ?string $modelLabel = 'cliente';
    # or
    public static function getModelLabel(): string
    {
        return __('filament/resources/customer.label');
    }
```

- plural

```php
class AdminResource extends Resource
{
    protected static ?string $pluralModelLabel = 'clientes';
    # or
    public static function getPluralModelLabel(): string
    {
        return __('filament/resources/customer.plural_label');
    }
```

- navigation

```php
protected static ?string $navigationLabel = 'Mis Clientes';

public static function getNavigationLabel(): string
{
    return __('filament/resources/customer.navigation_label');
}
```

- navigation group

```php
protected static ?string $navigationGroup = 'Shop';

protected static function getNavigationGroup(): ?string
{
    return return __('filament/navigation.groups.shop');
}
```
