<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Banner extends Model implements Sortable
{
    use HasFactory;
    use SortableTrait;

    protected $connection = 'mysql';

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];
}
