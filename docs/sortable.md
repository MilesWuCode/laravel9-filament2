```sh
composer require spatie/eloquent-sortable

php artisan vendor:publish --tag=eloquent-sortable-config
```

```php
// table
$table->bigInteger('order_column');

// model
class Banner extends Model implements Sortable
{
    use HasFactory;
    use SortableTrait;

    protected $connection = 'mysql';

    protected $fillable = [
        'name',
        'url',
        'order_column',
    ];

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];
}

// custom query
public function buildSortQuery()
{
    return static::query()->where('user_id', $this->user_id);
}
```
