<?php

namespace MaycolMunoz\MoonLeaflet\Providers;

use Illuminate\Support\ServiceProvider;

class MoonLeafletServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'moon-leaflet');
    }
}
