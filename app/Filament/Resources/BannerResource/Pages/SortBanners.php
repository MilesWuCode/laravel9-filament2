<?php

namespace App\Filament\Resources\BannerResource\Pages;

use App\Filament\Resources\BannerResource;
use Filament\Resources\Pages\Page;

class SortBanners extends Page
{
    protected static string $resource = BannerResource::class;

    protected static ?string $breadcrumb = 'Sort';

    protected static ?string $title = 'Sort';

    protected static string $view = 'filament.resources.banner-resource.pages.sort-banners';
}
