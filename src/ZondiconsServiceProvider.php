<?php

namespace Zondicons;

use BladeSvg\IconFactory;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ZondiconsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        app(IconFactory::class)->registerBladeTag();

        $this->publishes([
            __DIR__.'/../config/zondicons.php' => config_path('zondicons.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton(IconFactory::class, function () {
            $config = array_merge([
                'icon_path' => base_path('vendor/zondicons/blade-bridge/resources/icons'),
                'spritesheet_path' => base_path('vendor/zondicons/blade-bridge/resources/sprite.svg'),
                'sprite_prefix' => 'zondicon-',
            ], config('zondicons', []));

            return new IconFactory($config);
        });
    }
}
